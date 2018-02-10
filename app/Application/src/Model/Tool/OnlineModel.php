<?php
namespace Application\Tool;

use Ions\Mvc\Model;

class OnlineModel extends Model
{
    public function addOnline($ip, $id, $url, $referer) {
        $this->db->execute("DELETE FROM `user_online` WHERE date_added < '" . date('Y-m-d H:i:s', strtotime('-1 hour')) . "'");

        $this->db->execute("REPLACE INTO `user_online` SET `ip` = " . $this->db->escape($ip) . ", `user_id` = '" . (int)$id . "', `url` = " . $this->db->escape($url) . ", `referer` = " . $this->db->escape($referer) . ", `date_added` = " . $this->db->escape(date('Y-m-d H:i:s')));
    }
}
