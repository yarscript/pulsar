<?php
namespace Admin\Content;

use Ions\Mvc\Model;

class PageModel extends Model
{
    public function addPage($data)
    {
        $this->db->execute("INSERT INTO `page` SET top = '" . ((int)!isset($data['top']) ? 0 : $data['top']) . "', bottom = '" . ((int)!isset($data['bottom']) ? 0 : $data['bottom']) . "', `status` = '" . ((int)!isset($data['status']) ? 0 : $data['status'])  . "', date_added = NOW(), date_modified = NOW()");

        $page_id = $this->db->getLastId();

        foreach ($data['description'] as $language_id => $value) {
            $this->db->execute("INSERT INTO page_description SET page_id = '" . (int)$page_id . "', language_id = '" . (int)$language_id . "', name = " . $this->db->escape($value['name']) . ", description = " . $this->db->escape($value['description']) . ", meta_title = " . $this->db->escape($value['meta_title']) . ", meta_description = " . $this->db->escape($value['meta_description']) . ", meta_keyword = " . $this->db->escape($value['meta_keyword']));
        }

        $this->cache->remove('page');

        return $page_id;
    }

    public function editPage($id, $data)
    {
        if (isset($data)) {
            $this->db->execute("UPDATE `page` SET top = '" . ((int)!isset($data['top']) ? 0 : $data['top']) . "', bottom = '" . ((int)!isset($data['bottom']) ? 0 : $data['bottom']) . "', `status` = '" . ((int)!isset($data['status']) ? 0 : $data['status'])  . "', date_modified = NOW() WHERE id = '" . (int)$id . "'");
        }

        $this->db->execute("DELETE FROM `page_description` WHERE page_id = '" . (int)$id . "'");

        foreach ($data['description'] as $language_id => $value) {
            $this->db->execute("INSERT INTO `page_description` SET page_id = '" . (int)$id . "', language_id = '" . (int)$language_id . "', name = " . $this->db->escape($value['name']) . ", description = " . $this->db->escape($value['description']) . ", meta_title = " . $this->db->escape($value['meta_title']) . ", meta_description = " . $this->db->escape($value['meta_description']) . ", meta_keyword = " . $this->db->escape($value['meta_keyword']));
        }

       $this->cache->remove('page');
    }

    public function deletePage($id)
    {
        $this->db->execute("DELETE FROM `page` WHERE id = '" . (int)$id . "'");
        $this->db->execute("DELETE FROM `page_description` WHERE page_id = '" . (int)$id . "'");

        $this->cache->remove('page');
    }

    public function getPages(array $data = [])
    {
        $sql = "SELECT * FROM page p LEFT JOIN page_description pd ON (p.id = pd.page_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        if(!empty($data['top'])) {
            $sql .= " AND p.top = '1'";
        } elseif(!empty($data['bottom'])) {
            $sql .= " AND p.bottom = '1'";
        }

        $sql .= ' GROUP BY p.id ORDER BY pd.name';

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

    public function getPage($id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM page p LEFT JOIN page_description pd ON (p.id = pd.page_id) WHERE p.id = '" . (int)$id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->row;
    }

    public function getPageDescriptions($page_id)
    {
        $data = [];

        $query = $this->db->query("SELECT * FROM page_description WHERE page_id = '" . (int)$page_id . "'");

        foreach ($query->rows as $description) {
            $data[$description['language_id']] = $description;
        }

        return $data;
    }

    public function getTotalPages() {
        $sql = 'SELECT COUNT(DISTINCT p.id) AS total FROM page p LEFT JOIN page_description pd ON (p.id = pd.page_id)';

        $sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        $query = $this->db->query($sql);

        return $query->row['total'];
    }
}
