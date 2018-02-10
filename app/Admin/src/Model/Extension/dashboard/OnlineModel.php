<?php

namespace Admin\Extension\Dashboard;

use Ions\Mvc\Model;

class OnlineModel extends Model
{
    public function getTotalOnline($data = [])
    {
        $sql = "SELECT COUNT(*) AS total FROM `user_online` uo LEFT JOIN user u ON (uo.user_id = u.id)";

        $implode = [];

        if (!empty($data['filter_ip'])) {
            $implode[] = "uo.ip LIKE '" . $this->db->escape($data['filter_ip']) . "'";
        }

        if (!empty($data['filter_user'])) {
            $implode[] = "uo.user_id > 0 AND CONCAT(c.firstname, ' ', c.lastname) LIKE '" . $this->db->escape($data['filter_user']) . "'";
        }

        if ($implode) {
            $sql .= " WHERE " . implode(" AND ", $implode);
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }
}
