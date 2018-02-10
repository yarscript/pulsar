<?php

namespace Admin\User;

use Ions\Mvc\Model;

class GroupModel extends Model
{
    public function addUserGroup($data)
    {
        $this->db->execute("INSERT INTO user_group SET approval = '" . (!isset($data['approval']) ? 0 : (int)$data['approval']) . "', `permission` = " . $this->db->escape(json_encode($data['permission'])));

        $id = $this->db->getLastId();

        foreach ($data['description'] as $language_id => $value) {
            $this->db->execute("INSERT INTO user_group_description SET group_id = '" . (int)$id . "', language_id = '" . (int)$language_id . "', name = " . $this->db->escape($value['name']) . ", description = " . $this->db->escape($value['description']));
        }

        return $id;
    }

    public function editUserGroup($id, $data)
    {
        $this->db->execute("UPDATE user_group SET approval = '" . (!isset($data['approval']) ? 0 : (int)$data['approval']) . "', `permission` = " . $this->db->escape(json_encode($data['permission'])) . " WHERE id = '" . (int)$id . "'");

        $this->db->execute("DELETE FROM user_group_description WHERE group_id = '" . (int)$id . "'");

        foreach ($data['description'] as $language_id => $value) {
            $this->db->execute("INSERT INTO user_group_description SET group_id = '" . (int)$id . "', language_id = '" . (int)$language_id . "', name = " . $this->db->escape($value['name']) . ", description = " . $this->db->escape($value['description']));
        }
    }

    public function deleteUserGroup($id)
    {
        $this->db->execute("DELETE FROM user_group WHERE id = '" . (int)$id . "'");
        $this->db->execute("DELETE FROM user_group_description WHERE group_id = '" . (int)$id . "'");
    }

    public function getUserGroup($id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM user_group ug LEFT JOIN user_group_description ugd ON (ug.id = ugd.group_id) WHERE ug.id = '" . (int)$id . "' AND ugd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ugd.name");

        $query->row['permission'] = json_decode($query->row['permission'], true);

        return $query->row;
    }

    public function getUserGroups()
    {
        $query = $this->db->query("SELECT DISTINCT * FROM user_group ug LEFT JOIN user_group_description ugd ON (ug.id = ugd.group_id) WHERE ugd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ugd.name");

//        if (isset($data['start']) || isset($data['limit'])) {
//            if ($data['start'] < 0) {
//                $data['start'] = 0;
//            }
//
//            if ($data['limit'] < 1) {
//                $data['limit'] = 20;
//            }
//
//            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
//        }

        return $query->rows;
    }

    public function getUserGroupDescriptions($group_id)
    {
        $group_data = [];

        $query = $this->db->query("SELECT * FROM user_group_description WHERE group_id = '" . (int)$group_id . "'");

        foreach ($query->rows as $result) {
            $group_data[$result['language_id']] = [
                'name' => $result['name'],
                'description' => $result['description']
            ];
        }

        return $group_data;
    }

    public function getTotalUserGroups()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM user_group");

        return $query->row['total'];
    }

    public function addPermission($id, $type, $route)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM `user_group` WHERE `id` = '" . (int)$id . "'");

        if ($query->count) {
            $data = json_decode($query->row['permission'], true);

            $data[$type][] = $route;

            $this->db->execute("UPDATE `user_group` SET permission = " . $this->db->escape(json_encode($data)) . " WHERE `id` = '" . (int)$id . "'");
        }
    }
}
