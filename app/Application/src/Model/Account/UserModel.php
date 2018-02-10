<?php

namespace Application\Account;

use Ions\Mvc\Model;

class UserModel extends Model
{
    public function addUser($data)
    {
        if (isset($data['group_id']) && is_array($this->config->get('config_user_group_display')) && in_array($data['group_id'], $this->config->get('config_user_group_display'))) {
            $group_id = $data['group_id'];
        } else {
            $group_id = $this->config->get('config_user_group_id');
        }

        $user_group_info = $this->model('account/usergroup')->getUserGroup($group_id);

        $this->db->execute("INSERT INTO user SET group_id = '" . (int)$group_id . "', language_id = '" . (int)$this->config->get('config_language_id') . "', firstname = " . $this->db->escape($data['firstname']) . ", lastname = " . $this->db->escape($data['lastname']) . ", email = '" . $this->db->escape($data['email']) . "', password = " . $this->db->escape(password_hash($data['password'], PASSWORD_DEFAULT)) . ", ip = " . $this->db->escape($this->request->getServer('REMOTE_ADDR')) . ", status = '" . (int)!$user_group_info['approval'] . "', date_added = NOW()");

        $user_id = $this->db->getLastId();

        if ($user_group_info['approval']) {
            $this->db->execute("INSERT INTO `user_approval` SET user_id = '" . (int)$user_id . "', type = 'user', date_added = NOW()");
        }

        return $user_id;
    }

    public function editUser($id, $data)
    {
        $this->db->execute("UPDATE user SET firstname = " . $this->db->escape($data['firstname']) . ", lastname = " . $this->db->escape($data['lastname']) . ", email = " . $this->db->escape($data['email']) . " WHERE id = '" . (int)$id . "'");
    }

    public function editPassword($email, $password)
    {
        $this->db->execute("UPDATE user SET password = " . $this->db->escape(password_hash($password, PASSWORD_DEFAULT)) . " WHERE LOWER(email) = " . $this->db->escape(strtolower($email)));
    }

    public function getUser($id)
    {
        $query = $this->db->query("SELECT * FROM user WHERE id = '" . (int)$id . "'");

        return $query->row;
    }

    public function getUserByEmail($email)
    {
        $query = $this->db->query("SELECT * FROM user WHERE LOWER(email) = " . $this->db->escape(strtolower($email)));

        return $query->row;
    }

    public function getTotalUsersByEmail($email)
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM user WHERE LOWER(email) = " . $this->db->escape(strtolower($email)));

        return $query->row['total'];
    }

    public function getIps($user_id)
    {
        $query = $this->db->query("SELECT * FROM `user_ip` WHERE user_id = '" . (int)$user_id . "'");

        return $query->rows;
    }

    public function addLoginAttempt($email)
    {
        $query = $this->db->query("SELECT * FROM user_login WHERE email = " . $this->db->escape(strtolower((string)$email)) . " AND ip = " . $this->db->escape($this->request->getServer('REMOTE_ADDR')));

        if (!$query->num_rows) {
            $this->db->query("INSERT INTO user_login SET email = " . $this->db->escape(strtolower((string)$email)) . ", ip = " . $this->db->escape($this->request->server['REMOTE_ADDR']) . ", total = 1, date_added = " . $this->db->escape(date('Y-m-d H:i:s')) . ", date_modified = " . $this->db->escape(date('Y-m-d H:i:s')));
        } else {
            $this->db->execute("UPDATE user_login SET total = (total + 1), date_modified = " . $this->db->escape(date('Y-m-d H:i:s')) . " WHERE id = '" . (int)$query->row['id'] . "'");
        }
    }

    public function getLoginAttempts($email)
    {
        $query = $this->db->query("SELECT * FROM `user_login` WHERE email = " . $this->db->escape(strtolower($email)));

        return $query->row;
    }

    public function deleteLoginAttempts($email)
    {
        $this->db->query("DELETE FROM `user_login` WHERE email = " . $this->db->escape(strtolower($email)));
    }
}
