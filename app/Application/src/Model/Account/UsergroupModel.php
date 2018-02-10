<?php

namespace Application\Account;

use Ions\Mvc\Model;

class UsergroupModel extends Model
{
    public function getUserGroup($id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM user_group ug LEFT JOIN user_group_description ugd ON (ug.id = ugd.group_id) WHERE ug.id = '" . (int)$id . "' AND ugd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->row;
    }

    public function getUserGroups()
    {
        $query = $this->db->query("SELECT * FROM user_group ug LEFT JOIN user_group_description ugd ON (ug.id = ugd.group_id) WHERE ugd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ugd.name ASC");

        return $query->rows;
    }
}
