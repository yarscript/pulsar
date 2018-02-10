<?php
namespace Admin\Content;

use Ions\Mvc\Model;

class PostModel extends Model
{
    public function addPost($data)
    {
        $this->db->execute("INSERT INTO post SET `user_id` = '" . (int)$data['user_id'] . "',`status` = '" . (int)$data['status'] . "',`date_available` = " . $this->db->escape($data['date_available']) . ", date_added = NOW(), date_modified = NOW()");

        $id = $this->db->getLastId();

        if (isset($data['image'])) {
            $this->db->execute("UPDATE post SET image = " . $this->db->escape($data['image']) . " WHERE id = '" . (int)$id . "'");
        }

        foreach ($data['description'] as $language_id => $value) {
            $this->db->execute("INSERT INTO post_description SET post_id = '" . (int)$id . "', language_id = '" . (int)$language_id . "', `name` = " . $this->db->escape($value['name']) . ", description = " . $this->db->escape($value['description']) . ", tag = " . $this->db->escape($value['tag']) . ", meta_title = " . $this->db->escape($value['meta_title']) . ", meta_description = " . $this->db->escape($value['meta_description']) . ", meta_keyword = " . $this->db->escape($value['meta_keyword']));
        }

        if (isset($data['category'])) {
            foreach ($data['category'] as $category_id) {
                $this->db->execute("INSERT INTO post_to_category SET post_id = '" . (int)$id . "', category_id = '" . (int)$category_id . "'");
            }
        }

        if (isset($data['related'])) {
            foreach ($data['related'] as $related_id) {
                $this->db->execute("DELETE FROM post_related WHERE post_id = '" . (int)$id . "' AND related_id = '" . (int)$related_id . "'");
                $this->db->execute("INSERT INTO post_related SET post_id = '" . (int)$id . "', related_id = '" . (int)$related_id . "'");
            }
        }

        // SEO URL
        if (isset($data['seo_url'])) {
            foreach ($data['seo_url'] as $language) {
                foreach ($language as $language_id => $keyword) {
                    if (!empty($keyword)) {
                        $this->db->execute("INSERT INTO seo_url SET language_id = '" . (int)$language_id . "', `query` = 'post_id=" . (int)$id . "', keyword = " . $this->db->escape($keyword));
                    }
                }
            }
        }

        $this->cache->remove('post');

        return $id;
    }

    public function editPost($id, $data)
    {
        if (isset($data)) {
            $this->db->execute("UPDATE post SET `user_id` = '" . (int)$data['user_id'] . "',`status` = '" . (int)$data['status'] . "', `date_available` = " . $this->db->escape($data['date_available']) . ", date_modified = NOW() WHERE id = '" . (int)$id . "'");
        }

        if (isset($data['image'])) {
            $this->db->execute("UPDATE post SET image = " . $this->db->escape($data['image']) . " WHERE id = '" . (int)$id . "'");
        }

        $this->db->execute("DELETE FROM post_description WHERE post_id = '" . (int)$id . "'");

        foreach ($data['description'] as $language_id => $value) {
            $this->db->execute("INSERT INTO post_description SET post_id = '" . (int)$id . "', language_id = '" . (int)$language_id . "', name = " . $this->db->escape($value['name']) . ", description = " . $this->db->escape($value['description']) . ", tag = " . $this->db->escape($value['tag']) . ", meta_title = " . $this->db->escape($value['meta_title']) . ", meta_description = " . $this->db->escape($value['meta_description']) . ", meta_keyword = " . $this->db->escape($value['meta_keyword']));
        }

        $this->db->execute("DELETE FROM post_to_category WHERE post_id = '" . (int)$id . "'");

        if (isset($data['category'])) {
            foreach ($data['category'] as $category_id) {
                $this->db->execute("INSERT INTO post_to_category SET post_id = '" . (int)$id . "', category_id = '" . (int)$category_id . "'");
            }
        }

        if (isset($data['related'])) {
            foreach ($data['related'] as $related_id) {
                $this->db->execute("DELETE FROM post_related WHERE post_id = '" . (int)$id . "' AND related_id = '" . (int)$related_id . "'");
                $this->db->execute("INSERT INTO post_related SET post_id = '" . (int)$id . "', related_id = '" . (int)$related_id . "'");
            }
        }

        // SEO URL
        $this->db->execute("DELETE FROM seo_url WHERE query = 'post_id=" . (int)$id . "'");

        if (isset($data['seo_url'])) {
            foreach ($data['seo_url']as $language) {
                foreach ($language as $language_id => $keyword) {
                    if (!empty($keyword)) {
                        $this->db->execute("INSERT INTO seo_url SET language_id = '" . (int)$language_id . "', query = 'post_id=" . (int)$id . "', keyword = " . $this->db->escape($keyword));
                    }
                }
            }
        }

        $this->cache->remove('post');
    }

    public function deletePost($id)
    {
        $this->db->execute("DELETE FROM post WHERE id = '" . (int)$id . "'");
        $this->db->execute("DELETE FROM post_description WHERE post_id = '" . (int)$id . "'");
        $this->db->execute("DELETE FROM post_to_category WHERE post_id = '" . (int)$id . "'");
        $this->db->execute("DELETE FROM seo_url WHERE query = 'post_id=" . (int)$id . "'");

        $this->cache->remove('post');
    }

    public function getPosts(array $data = [])
    {
        $sql = "SELECT * FROM post p LEFT JOIN post_description pd ON (p.id = pd.post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        $sql .= " GROUP BY p.id";

        $sort_data = [
            'pd.name',
            'p.status'
        ];

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY pd.name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
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

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getPost($id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM post p LEFT JOIN post_description pd ON (p.id = pd.post_id) WHERE p.id = '" . (int)$id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->row;
    }

    public function getPostsByCategoryId($category_id) {
        $query = $this->db->query("SELECT * FROM post p LEFT JOIN post_description pd ON (p.id = pd.post_id) LEFT JOIN post_to_category p2c ON (p.id = p2c.post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");

        return $query->rows;
    }

    public function getPostCategories($post_id) {
        $post_category_data = [];

        $query = $this->db->query("SELECT * FROM post_to_category WHERE post_id = '" . (int)$post_id . "'");

        foreach ($query->rows as $result) {
            $post_category_data[] = $result['category_id'];
        }

        return $post_category_data;
    }

    public function getPostDescriptions($post_id)
    {
        $data = [];

        $query = $this->db->query("SELECT * FROM post_description WHERE post_id = '" . (int)$post_id . "'");

        foreach ($query->rows as $description) {
            $data[$description['language_id']] = $description;
        }

        return $data;
    }

    public function getPostSeoUrls($id) {
        $query = $this->db->query("SELECT * FROM seo_url WHERE query = 'post_id=" . (int)$id . "'");

        return $query->rows;
    }

    public function getPostRelated($post_id) {
        $related_data = [];

        $query = $this->db->query("SELECT * FROM post_related WHERE post_id = '" . (int)$post_id . "'");

        foreach ($query->rows as $result) {
            $related_data[] = $result['related_id'];
        }

        return $related_data;
    }

    public function getTotalPosts() {
        $sql = 'SELECT COUNT(DISTINCT p.id) AS total FROM post p LEFT JOIN post_description pd ON (p.id = pd.post_id)';

        $sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        $query = $this->db->query($sql);

        return $query->row['total'];
    }
}
