<?php

namespace Admin\Setting;

use Ions\Mvc\Model;

class ModuleModel extends Model
{
    public function addModule($code, $data)
    {
        $this->db->execute("INSERT INTO `module` SET `name` = " . $this->db->escape($data['name']) . ", `code` = " . $this->db->escape($code) . ", `setting` = " . $this->db->escape(json_encode($data)));
    }

    public function editModule($id, $data)
    {
        $this->db->execute("UPDATE `module` SET `name` = " . $this->db->escape($data['name']) . ", `setting` = " . $this->db->escape(json_encode($data)) . " WHERE `id` = '" . (int)$id . "'");
    }

    public function deleteModule($id)
    {
        $this->db->execute("DELETE FROM `module` WHERE `id` = '" . (int)$id . "'");
    }

    public function getModule($id)
    {
        $query = $this->db->query("SELECT * FROM `module` WHERE `id` = '" . (int)$id . "'");

        if ($query->row) {
            return json_decode($query->row['setting'], true);
        } else {
            return [];
        }
    }

    public function getModules()
    {
        $query = $this->db->query("SELECT * FROM `module` ORDER BY `code`");

        return $query->rows;
    }

    public function getModulesByCode($code)
    {
        $query = $this->db->query("SELECT * FROM `module` WHERE `code` = " . $this->db->escape($code) . " ORDER BY `name`");

        return $query->rows;
    }

    public function deleteModulesByCode($code)
    {
        $this->db->execute("DELETE FROM `module` WHERE `code` = " . $this->db->escape($code));
    }
}
