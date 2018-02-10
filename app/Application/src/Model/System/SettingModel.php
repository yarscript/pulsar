<?php
namespace Application\System;

use Ions\Mvc\Model;

class SettingModel extends Model
{
	public function getSetting($code, $store_id = 0) {
		$data = array();

		$query = $this->db->query("SELECT * FROM setting WHERE `code` = " . $this->db->escape($code));

		foreach ($query->rows as $result) {
			if (!$result['serialized']) {
				$data[$result['key']] = $result['value'];
			} else {
				$data[$result['key']] = json_decode($result['value'], true);
			}
		}

		return $data;
	}
	
	public function getSettingValue($key) {
		$query = $this->db->query("SELECT value FROM setting WHERE `key` = " . $this->db->escape($key));

		if ($query->num_rows) {
			return $query->row['value'];
		} else {
			return null;	
		}
	}	
}
