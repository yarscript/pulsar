<?php

namespace Admin\System;

use Ions\Mvc\Model;

class SettingModel extends Model
{
    public function getSetting($code)
    {
        $data = [];

        $query = $this->db->query('SELECT * FROM `setting` WHERE `code` = ' . $this->db->escape($code));

        foreach ($query->rows as $result) {
            if (!$result['serialized']) {
                $data[$result['key']] = $result['value'];
            } else {
                $data[$result['key']] = json_decode($result['value'], true);
            }
        }

        return $data;
    }

    public function editSetting($code, $data)
    {
        $this->db->execute('DELETE FROM `setting` WHERE `code` = ' . $this->db->escape($code));

        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $this->db->execute('INSERT INTO `setting` SET `code` = ' . $this->db->escape($code) . ', `key` = ' . $this->db->escape($key) . ', `value` = ' . $this->db->escape($value) . ", serialized = '0'");
            } else {
                $this->db->execute('INSERT INTO `setting` SET `code` = ' . $this->db->escape($code) . ', `key` = ' . $this->db->escape($key) . ', `value` = ' . $this->db->escape(json_encode($value, true)) . ", serialized = '1'");
            }
        }
    }

    public function deleteSetting($code)
    {
        $this->db->execute('DELETE FROM `setting` WHERE `code` = ' . $this->db->escape($code));
    }

    public function getSettingValue($key)
    {
        $query = $this->db->query('SELECT `value` FROM `setting` WHERE `key` = ' . $this->db->escape($key));

        if ($query->count) {
            return $query->row['value'];
        } else {
            return null;
        }
    }

    public function editSettingValue($code, $key, $value)
    {
        if (!is_array($value)) {
            $this->db->execute('UPDATE setting SET `value` = ' . $this->db->escape($value) . ", serialized = '0'  WHERE `code` = " . $this->db->escape($code) . ' AND `key` = ' . $this->db->escape($key));
        } else {
            $this->db->execute('UPDATE setting SET `value` = ' . $this->db->escape(json_encode($value)) . ", serialized = '1' WHERE `code` = " . $this->db->escape($code) . ' AND `key` = ' . $this->db->escape($key));
        }
    }
}
