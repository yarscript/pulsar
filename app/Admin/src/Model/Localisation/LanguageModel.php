<?php

namespace Admin\Localisation;

use Ions\Mvc\Model;

class LanguageModel extends Model
{
    public function addLanguage($data)
    {
        $this->db->execute("INSERT INTO `language` SET `name` = " . $this->db->escape($data['name']) . ", `code` = " . $this->db->escape($data['code']) . ", `locale` = " . $this->db->escape($data['locale']) . ", `sort_order` = " . $this->db->escape($data['sort_order']) . ", `status` = '" . (int)$data['status'] . "'");

        $this->cache->remove('language');

        $language_id = $this->db->getLastId();

        // Category
        $query = $this->db->query("SELECT * FROM `category_description` WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");

        foreach ($query->rows as $category) {
            $this->db->execute("INSERT INTO category_description SET category_id = '" . (int)$category['category_id'] . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($category['name']) . "', description = '" . $this->db->escape($category['description']) . "', meta_title = '" . $this->db->escape($category['meta_title']) . "', meta_description = '" . $this->db->escape($category['meta_description']) . "', meta_keyword = '" . $this->db->escape($category['meta_keyword']) . "'");
        }

        $this->cache->remove('category');

        return $language_id;
    }

    public function editLanguage($id, $data)
    {
        $language_query = $this->db->query("SELECT `code` FROM `language` WHERE `id` = '" . (int)$id . "'");

        $this->db->execute("UPDATE `language` SET `name` = " . $this->db->escape($data['name']) . ", `code` = " . $this->db->escape($data['code']) . ", `locale` = " . $this->db->escape($data['locale']) . ", `sort_order` = '" . (int)$data['sort_order'] . "', `status` = '" . (int)$data['status'] . "' WHERE `id` = '" . (int)$id . "'");

        if ($language_query->row['code'] != $data['code']) {
            $this->db->execute("UPDATE `setting` SET `value` = " . $this->db->escape($data['code']) . " WHERE `key` = 'config_language' AND value = " . $this->db->escape($language_query->row['code']));
            $this->db->execute("UPDATE `setting` SET `value` = " . $this->db->escape($data['code']) . " WHERE `key` = 'config_admin_language' AND value = " . $this->db->escape($language_query->row['code']));
        }

        $this->cache->remove('language');
    }

    public function deleteLanguage($id)
    {
        $this->db->execute("DELETE FROM `language` WHERE `id` = '" . (int)$id . "'");

        $this->cache->remove('language');

        $this->db->execute("DELETE FROM category_description WHERE language_id = '" . (int)$id . "'");

        $this->cache->remove('category');
    }

    public function getLanguage($id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM `language` WHERE id = '" . (int)$id . "'");

        return $query->row;
    }

    public function getLanguages()
    {
        $language_data = json_decode($this->cache->get('language'), true);

        if (!$language_data) {
            $language_data = [];

            $query = $this->db->query('SELECT * FROM `language` ORDER BY sort_order, `name`');

            foreach ($query->rows as $result) {
                $language_data[$result['code']] = [
                    'id' => $result['id'],
                    'name' => $result['name'],
                    'code' => $result['code'],
                    'locale' => $result['locale'],
                    'sort_order' => $result['sort_order'],
                    'status' => $result['status']
                ];
            }

            $this->cache->set('language', json_encode($language_data));
        }

        return $language_data;
    }

    public function getLanguageByCode($code)
    {
        $query = $this->db->query("SELECT * FROM `language` WHERE `code` = " . $this->db->escape($code));

        return $query->row;
    }

    public function getTotalLanguages()
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM `language`');

        return $query->row['total'];
    }
}
