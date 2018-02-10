<?php

namespace Application\Content;

use Ions\Mvc\Model;

class PostModel extends Model
{
    public function updateViewed($id)
    {
        $this->db->execute("UPDATE post SET viewed = (viewed + 1) WHERE id = '" . (int)$id . "'");
    }

    public function getPost($id)
    {
        $query = $this->db->query("SELECT DISTINCT *, CONCAT(u.firstname, ' ', u.lastname) AS author, pd.name AS name, p.image, p.sort_order FROM post p LEFT JOIN post_description pd ON (p.id = pd.post_id) LEFT JOIN user u ON (u.id = p.user_id) WHERE p.id = '" . (int)$id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW()");

        $date = new \DateTime($query->row['date_added']);
        $interval = $date->diff(new \DateTime());

        if ($interval->y) {
            $ago = $interval->y . ' year';
        } elseif ($interval->m) {
            $ago = $interval->m . ' mon';
        } elseif ($interval->d) {
            $ago = $interval->d . ' day';
        } elseif ($interval->h) {
            $ago = $interval->h . ' hour';
        } elseif ($interval->i) {
            $ago = $interval->i . ' min';
        } else {
            $ago = $interval->s . ' sec';
        }

        if ($query->count) {
            return [
                'id' => $query->row['id'],
                'name' => $query->row['name'],
                'description' => $query->row['description'],
                'meta_title' => $query->row['meta_title'],
                'meta_description' => $query->row['meta_description'],
                'meta_keyword' => $query->row['meta_keyword'],
                'tag' => $query->row['tag'],
                'image' => $query->row['image'],
                'author' => $query->row['author'],
                'date_available' => $query->row['date_available'],
                'sort_order' => $query->row['sort_order'],
                'status' => $query->row['status'],
                'date' => $date->format('M d, Y'),
                'ago' => $ago,
                'viewed' => $query->row['viewed']
            ];
        }

        return false;
    }

    public function getPosts($data = [], $category_id = 0)
    {
        $sql = "SELECT p.id ";

        if ($category_id) {
            $sql .= " FROM post_to_category p2c LEFT JOIN post p ON (p2c.post_id = p.id)";
        } else {
            $sql .= " FROM post p";
        }

        $sql .= " LEFT JOIN post_description pd ON (p.id = pd.post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW()";

        if ($category_id) {
            $sql .= " AND p2c.category_id = '" . (int)$category_id . "'";
        }

        $sql .= " GROUP BY p.id";

        $sql .= " ORDER BY p.sort_order";

        if (isset($data['order']) && ($data['order'] === 'DESC')) {
            $sql .= " DESC, LCASE(pd.name) DESC";
        } else {
            $sql .= " ASC, LCASE(pd.name) ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $post_data = array();

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $post_data[$result['id']] = $this->getPost($result['id']);
        }

        return $post_data;
    }

    public function getPostRelated($id)
    {
        $post_data = [];

        $query = $this->db->query("SELECT * FROM post_related pr LEFT JOIN post p ON (pr.related_id = p.id) WHERE pr.post_id = '" . (int)$id . "' AND p.status = '1' AND p.date_available <= NOW()");

        foreach ($query->rows as $result) {
            $post_data[$result['id']] = $this->getPost($result['id']);
        }

        return $post_data;
    }

    public function getCategories($post_id)
    {
        $query = $this->db->query("SELECT * FROM post_to_category WHERE post_id = '" . (int)$post_id . "'");

        return $query->rows;
    }

    public function getTotalPosts($data = [], $category_id = 0)
    {
        $sql = "SELECT COUNT(DISTINCT p.id) AS total";

        if ($category_id) {
            $sql .= " FROM post_to_category p2c LEFT JOIN post p ON (p2c.post_id = p.id)";
        } else {
            $sql .= " FROM post p";
        }

        $sql .= " LEFT JOIN post_description pd ON (p.id = pd.post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW()";

        if ($category_id) {
            $sql .= " AND p2c.category_id = '" . (int)$category_id . "'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }
}
