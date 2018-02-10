<?php

namespace Admin\Content;

use Ions\Mvc\Model;

class CategoryModel extends Model
{
    public function addCategory($data)
    {
        $this->db->execute("INSERT INTO category SET parent_id = '" . (int)$data['parent_id'] . "', `status` = '" . ((int)!isset($data['status']) ? 0 : $data['status']) . "', date_modified = NOW(), date_added = NOW()");

        $id = $this->db->getLastId();

        if (isset($data['image'])) {
            $this->db->execute("UPDATE category SET image = " . $this->db->escape($data['image']) . " WHERE id = '" . (int)$id . "'");
        }

        foreach ($data['description'] as $language_id => $value) {
            $this->db->execute("INSERT INTO category_description SET category_id = '" . (int)$id . "', language_id = '" . (int)$language_id . "', `name` = " . $this->db->escape($value['name']) . ", description = " . $this->db->escape($value['description']) . ", meta_title = " . $this->db->escape($value['meta_title']) . ", meta_description = " . $this->db->escape($value['meta_description']) . ", meta_keyword = " . $this->db->escape($value['meta_keyword']));
        }

        // MySQL Hierarchical Data Closure Table Pattern
        $level = 0;

        $query = $this->db->query("SELECT * FROM `category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

        foreach ($query->rows as $result) {
            $this->db->execute("INSERT INTO `category_path` SET `category_id` = '" . (int)$id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

            $level++;
        }

        $this->db->execute("INSERT INTO `category_path` SET `category_id` = '" . (int)$id . "', `path_id` = '" . (int)$id . "', `level` = '" . (int)$level . "'");

        if (isset($data['seo_url'])) {
                foreach ($data['seo_url'] as $language_id => $keyword) {
                    if (!empty($keyword)) {
                        $this->db->execute("INSERT INTO seo_url SET language_id = '" . (int)$language_id . "', query = 'path=" . (int)$id . "', keyword = '" . $this->db->escape($keyword) . "'");
                    }
                }
        }

        $this->cache->remove('category');

        return $id;
    }

    public function editCategory($id, $data)
    {
        $this->db->execute("UPDATE category SET parent_id = '" . (int)$data['parent_id'] . "', `status` = '" . ((int)!isset($data['status']) ? 0 : $data['status']) . "', date_modified = NOW() WHERE id = '" . (int)$id . "'");

        if (isset($data['image'])) {
            $this->db->execute("UPDATE category SET image = " . $this->db->escape($data['image']) . " WHERE id = '" . (int)$id . "'");
        }

        $this->db->execute("DELETE FROM category_description WHERE category_id = '" . (int)$id . "'");

        foreach ($data['description'] as $language_id => $value) {
            $this->db->execute("INSERT INTO category_description SET category_id = '" . (int)$id . "', language_id = '" . (int)$language_id . "', name = " . $this->db->escape($value['name']) . ", description = " . $this->db->escape($value['description']) . ", meta_title = " . $this->db->escape($value['meta_title']) . ", meta_description = " . $this->db->escape($value['meta_description']) . ", meta_keyword = " . $this->db->escape($value['meta_keyword']));
        }

        // MySQL Hierarchical Data Closure Table Pattern
        $query = $this->db->query("SELECT * FROM `category_path` WHERE path_id = '" . (int)$id . "' ORDER BY level ASC");

        if ($query->rows) {
            foreach ($query->rows as $category_path) {
                // Delete the path below the current one
                $this->db->execute("DELETE FROM `category_path` WHERE category_id = '" . (int)$category_path['category_id'] . "' AND LEVEL < '" . (int)$category_path['level'] . "'");

                $path = [];

                // Get the nodes new parents
                $query = $this->db->query("SELECT * FROM `category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY LEVEL ASC");

                foreach ($query->rows as $result) {
                    $path[] = $result['path_id'];
                }

                // Get whats left of the nodes current path
                $query = $this->db->query("SELECT * FROM `category_path` WHERE category_id = '" . (int)$category_path['category_id'] . "' ORDER BY LEVEL ASC");

                foreach ($query->rows as $result) {
                    $path[] = $result['path_id'];
                }

                // Combine the paths with a new level
                $level = 0;

                foreach ($path as $path_id) {
                    $this->db->execute("REPLACE INTO `category_path` SET category_id = '" . (int)$category_path['category_id'] . "', `path_id` = '" . (int)$path_id . "', LEVEL = '" . (int)$level . "'");

                    $level++;
                }
            }
        } else {
            // Delete the path below the current one
            $this->db->execute("DELETE FROM `category_path` WHERE category_id = '" . (int)$id . "'");

            // Fix for records with no paths
            $level = 0;

            $query = $this->db->query("SELECT * FROM `category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY LEVEL ASC");

            foreach ($query->rows as $result) {
                $this->db->execute("INSERT INTO `category_path` SET category_id = '" . (int)$id . "', `path_id` = '" . (int)$result['path_id'] . "', LEVEL = '" . (int)$level . "'");

                $level++;
            }

            $this->db->execute("REPLACE INTO `category_path` SET category_id = '" . (int)$id . "', `path_id` = '" . (int)$id . "', level = '" . (int)$level . "'");
        }


        // SEO URL
        $this->db->execute("DELETE FROM `seo_url` WHERE query = 'path=" . (int)$id . "'");

        if (isset($data['seo_url'])) {
            foreach ($data['seo_url'] as $language_id => $keyword) {
                if (!empty($keyword)) {
                    $this->db->execute("INSERT INTO seo_url SET language_id = '" . (int)$language_id . "', `query` = 'path=" . (int)$id . "', keyword = " . $this->db->escape($keyword) . ", push = ''");
                }
            }
        }

        $this->cache->remove('category');
    }

    public function deleteCategory($id)
    {
        $this->db->execute("DELETE FROM category_path WHERE category_id = '" . (int)$id . "'");

        $query = $this->db->query("SELECT * FROM category_path WHERE path_id = '" . (int)$id . "'");

        foreach ($query->rows as $result) {
            $this->deleteCategory($result['category_id']);
        }

        $this->db->execute("DELETE FROM category WHERE id = '" . (int)$id . "'");
        $this->db->execute("DELETE FROM category_description WHERE category_id = '" . (int)$id . "'");
        $this->db->execute("DELETE FROM post_to_category WHERE category_id = '" . (int)$id . "'");
        $this->db->execute("DELETE FROM seo_url WHERE query = 'path=" . (int)$id . "'");

        $this->cache->remove('category');
    }

    public function getCategory($id)
    {
        $query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM category_path cp LEFT JOIN category_description cd1 ON (cp.path_id = cd1.category_id AND cp.category_id != cp.path_id) WHERE cp.category_id = c.id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.category_id) AS path FROM category c LEFT JOIN category_description cd2 ON (c.id = cd2.category_id) WHERE c.id = '" . (int)$id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->row;
    }

    public function getCategories($data = [])
    {
        $sql = "SELECT cp.category_id AS id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS path, c1.parent_id, c1.status, c1.image FROM category_path cp LEFT JOIN category c1 ON (cp.category_id = c1.id) LEFT JOIN category c2 ON (cp.path_id = c2.id) LEFT JOIN category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        if (!empty($data['name'])) {
            $sql .= ' AND cd2.name LIKE ' . $this->db->escape('%' . $data['name'] . '%');
        }

        $sql .= ' GROUP BY cp.category_id ORDER BY path';

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= ' LIMIT ' . (int)$data['start'] . ',' . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getCategoryDescriptions($category_id)
    {
        $category_description_data = [];

        $query = $this->db->query("SELECT * FROM category_description WHERE category_id = '" . (int)$category_id . "'");

        foreach ($query->rows as $result) {
            $category_description_data[$result['language_id']] = array(
                'name' => $result['name'],
                'meta_title' => $result['meta_title'],
                'meta_description' => $result['meta_description'],
                'meta_keyword' => $result['meta_keyword'],
                'description' => $result['description']
            );
        }

        return $category_description_data;
    }

    public function getCategoryPath($category_id)
    {
        $query = $this->db->query("SELECT category_id, path_id, level FROM category_path WHERE category_id = '" . (int)$category_id . "'");

        return $query->rows;
    }

    public function getCategorySeoUrls($category_id)
    {
        $seo_url_data = [];

        $query = $this->db->query("SELECT * FROM seo_url WHERE query = 'path=" . (int)$category_id . "'");

        foreach ($query->rows as $result) {
            $seo_url_data[$result['language_id']] = $result['keyword'];
        }

        return $seo_url_data;
    }

    public function getTotalCategories()
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM category');

        return $query->row['total'];
    }
}
