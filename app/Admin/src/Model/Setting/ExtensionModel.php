<?php

namespace Admin\Setting;

use Ions\Mvc\Model;

class ExtensionModel extends Model
{
    public function getInstalled($type)
    {
        $extension_data = [];

        $query = $this->db->query("SELECT * FROM `extension` WHERE `type` = " . $this->db->escape($type) . " ORDER BY `code`");

        foreach ($query->rows as $result) {
            $extension_data[] = $result['code'];
        }

        return $extension_data;
    }

    public function install($type, $code)
    {
        $extensions = $this->getInstalled($type);

        if (!in_array($code, $extensions)) {
            $this->db->execute("INSERT INTO `extension` SET `type` = " . $this->db->escape($type) . ", `code` = " . $this->db->escape($code));
        }
    }

    public function uninstall($type, $code)
    {
        $this->db->execute("DELETE FROM `extension` WHERE `type` = " . $this->db->escape($type) . " AND `code` = " . $this->db->escape($code));
        $this->db->execute("DELETE FROM `setting` WHERE `code` = " . $this->db->escape($type . '_' . $code));
    }
}
