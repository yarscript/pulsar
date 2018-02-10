<?php

namespace Application\Content;

use Ions\Mvc\Model;

class PageModel extends Model
{
    public function updateViewed($id)
    {
        $this->db->execute("UPDATE page SET viewed = (viewed + 1) WHERE id = '" . (int)$id . "'");
    }

    public function getPage($id)
    {
        $query = $this->db->query("SELECT DISTINCT *, pd.name AS name FROM page p LEFT JOIN page_description pd ON (p.id = pd.page_id) WHERE p.id = '" . (int)$id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->row;
    }

    public function getPages($data = [])
    {
        $sql = "SELECT p.id FROM page p LEFT JOIN page_description pd ON (p.id = pd.page_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1'";

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

        $page_data = [];

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $page_data[$result['id']] = $this->getPage($result['id']);
        }

        return $page_data;
    }

    public function getTotalPages()
    {
        $sql = "SELECT COUNT(DISTINCT p.id) AS total FROM page p LEFT JOIN page_description pd ON (p.id = pd.page_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1'";

        $query = $this->db->query($sql);

        return $query->row['total'];
    }
}
