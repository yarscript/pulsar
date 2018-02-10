<?php

namespace Admin\Design;

use Ions\Mvc\Model;

class SeoModel extends Model
{
    public function addSeoUrl($data)
    {
        $this->db->execute("INSERT INTO `seo_url` SET language_id = '" . (int)$data['language_id'] . "', `query` = " . $this->db->escape($data['query']) . ", keyword = " . $this->db->escape($data['keyword']) . ", push = " . $this->db->escape($data['push']));
    }

    public function editSeoUrl($id, $data)
    {
        $this->db->execute("UPDATE `seo_url` SET language_id = '" . (int)$data['language_id'] . "', `query` = " . $this->db->escape($data['query']) . ", keyword = " . $this->db->escape($data['keyword']) . ", push = " . $this->db->escape($data['push']) . " WHERE id = '" . (int)$id . "'");
    }

    public function deleteSeoUrl($id)
    {
        $this->db->execute("DELETE FROM `seo_url` WHERE id = '" . (int)$id . "'");
    }

    public function getSeoUrl($id)
    {
        $query = $this->db->query("SELECT * FROM `seo_url` WHERE id = '" . (int)$id . "'");

        return $query->row;
    }

    public function getSeoUrls($data = [])
    {
        $sql = "SELECT *, (SELECT `name` FROM `language` l WHERE l.id = su.language_id) AS language FROM `seo_url` su";

        $sql .= " ORDER BY query";

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

    public function getTotalSeoUrls()
    {
        $sql = "SELECT COUNT(*) AS total FROM `seo_url`";

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getSeoUrlsByKeyword($keyword)
    {
        $query = $this->db->query("SELECT * FROM `seo_url` WHERE keyword = '" . $this->db->escape($keyword) . "'");

        return $query->rows;
    }

    public function getSeoUrlsByQuery($keyword)
    {
        $query = $this->db->query("SELECT * FROM `seo_url` WHERE keyword = '" . $this->db->escape($keyword) . "'");

        return $query->rows;
    }
}
