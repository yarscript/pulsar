<?php

namespace Application\Account;

use Ions\Mvc\Model;

class ActivityModel extends Model
{
    public function addActivity($key, $data)
    {
        if (isset($data['user_id'])) {
            $user_id = $data['user_id'];
        } else {
            $user_id = 0;
        }

        $this->db->execute("INSERT INTO `user_activity` SET `user_id` = '" . (int)$user_id . "', `key` = " . $this->db->escape($key) . ", `data` = " . $this->db->escape(json_encode($data)) . ", `ip` = " . $this->db->escape($this->request->getServer('REMOTE_ADDR')) . ", `date_added` = NOW()");
    }
}
