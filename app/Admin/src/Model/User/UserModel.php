<?php

namespace Admin\User;

use Ions\Mvc\Model;

class UserModel extends Model
{
    public function addUser($data)
    {
        $this->db->execute("INSERT INTO `user` SET `group_id` = '" . (int)$data['group_id'] . "',`username` = " . $this->db->escape($data['username']) . ", `password` = " . $this->db->escape(password_hash($data['password'], PASSWORD_DEFAULT)) . ", `firstname` = " . $this->db->escape($data['firstname']) . ", `lastname` = " . $this->db->escape($data['lastname']) . ", `email` = " . $this->db->escape($data['email']) . ", `image` = " . $this->db->escape($data['image']) . ", `ip` = " . $this->db->escape($data['ip']) . ", `status` = '" . (int)$data['status'] . "', date_added = NOW()");

        return $this->db->getLastId();
    }

    public function editUser($id, $data)
    {
        $this->db->execute("UPDATE `user` SET `group_id` = " . (int)$data['group_id'] . ", `username` = " . $this->db->escape($data['username']) . ", `firstname` = " . $this->db->escape($data['firstname']) . ", `lastname` = " . $this->db->escape($data['lastname']) . ", `email` = " . $this->db->escape($data['email']) . ", `image` = " . $this->db->escape($data['image']) . ", `status` = '" . (int)$data['status'] . "' WHERE `id` = '" . (int)$id . "'");

        if ($data['password']) {
            $this->db->execute("UPDATE `user` SET `password` = " . $this->db->escape(password_hash($data['password'], PASSWORD_DEFAULT)) . " WHERE `id` = '" . (int)$id . "'");
        }
    }

    public function editPassword($id, $password)
    {
        $this->db->execute("UPDATE `user` SET `password` = " . $this->db->escape(password_hash($password, PASSWORD_DEFAULT)) . ", `code` = '' WHERE `id` = '" . (int)$id . "'");
    }

    public function deleteUser($id)
    {
        $this->db->execute("DELETE FROM `user` WHERE id = '" . (int)$id . "'");
        $this->db->execute("DELETE FROM `user_activity` WHERE user_id = '" . (int)$id . "'");
        $this->db->execute("DELETE FROM `user_approval` WHERE user_id = '" . (int)$id . "'");
        $this->db->execute("DELETE FROM `user_ip` WHERE user_id = '" . (int)$id . "'");
    }

    public function getUser($id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM `user` u WHERE id = '" . (int)$id . "'");

        return $query->row;
    }

    public function getUserByUsername($username) {
        $query = $this->db->query("SELECT * FROM `user` WHERE username = " . $this->db->escape($username));

        return $query->row;
    }

    public function getUserByEmail($email) {
        $query = $this->db->query("SELECT DISTINCT * FROM `user` WHERE LCASE(email) = " . $this->db->escape(strtolower($email)));

        return $query->row;
    }

    public function getTotalUsersByEmail($email) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `user` WHERE LCASE(email) = " . $this->db->escape(strtolower($email)));

        return $query->row['total'];
    }

    public function getUsers($language_id, $data = [])
    {
        $sql = "SELECT *, CONCAT(u.firstname, ' ', u.lastname) AS name, ugd.name AS user_group FROM `user` u LEFT JOIN user_group_description ugd ON (u.group_id = ugd.group_id) WHERE ugd.language_id = '" . (int)$language_id . "' ORDER BY name";

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

    public function getTotalUsers()
    {
        $sql = "SELECT COUNT(*) AS total FROM `user`";

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getTotalUsersByUserGroupId($group_id)
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM user WHERE group_id = '" . (int)$group_id . "'");

        return $query->row['total'];
    }

    public function getIps($user_id, $start = 0, $limit = 10)
    {
        if ($start < 0) {
            $start = 0;
        }
        if ($limit < 1) {
            $limit = 10;
        }

        $query = $this->db->query("SELECT * FROM user_ip WHERE user_id = '" . (int)$user_id . "' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

        return $query->rows;
    }

    public function getTotalIps($user_id)
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM user_ip WHERE user_id = '" . (int)$user_id . "'");

        return $query->row['total'];
    }

    public function getTotalUsersByIp($ip)
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM user_ip WHERE ip = " . $this->db->escape($ip));

        return $query->row['total'];
    }

    public function getTotalLoginAttempts($email)
    {
        $query = $this->db->query("SELECT * FROM `user_login` WHERE `email` = " . $this->db->escape($email));

        return $query->row;
    }

    public function deleteLoginAttempts($email)
    {
        $this->db->execute("DELETE FROM `user_login` WHERE `email` = " . $this->db->escape($email));
    }

    /*

    public function getUser($id)
    {
        $query = $this->db->query("SELECT *, (SELECT g.`name` FROM `user_group` g WHERE g.`id` = u.`group_id`) AS `group` FROM `user` u WHERE u.`id` = '" . (int)$id . "'");

        return $query->row;
    }*/
}
