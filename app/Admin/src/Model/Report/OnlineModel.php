<?php

namespace Admin\Report;

use Ions\Mvc\Model;

class OnlineModel extends Model
{

    public function getOnline($data = [])
    {
        $sql = "SELECT uo.ip, uo.user_id, uo.url, uo.referer, uo.date_added FROM user_online uo LEFT JOIN user u ON (uo.user_id = u.id)";

        $sql .= " ORDER BY uo.date_added DESC";

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

    public function getTotalOnline()
    {
        $sql = "SELECT COUNT(*) AS total FROM `user_online` uo LEFT JOIN user u ON (uo.user_id = u.id)";

        $query = $this->db->query($sql);

        return $query->row['total'];
    }
}
