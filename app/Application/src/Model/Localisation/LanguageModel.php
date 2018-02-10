<?php
namespace Application\Localisation;

use Ions\Mvc\Model;

class LanguageModel extends Model
{
	public function getLanguage($id) {
		$query = $this->db->query("SELECT * FROM `language` WHERE id = '" . (int)$id . "'");

		return $query->row;
	}

	public function getLanguages() {
		$language_data = json_decode($this->cache->get('language'), true);

		if (!$language_data) {
			$language_data = [];

			$query = $this->db->query("SELECT * FROM `language` WHERE status = '1' ORDER BY sort_order, name");

			foreach ($query->rows as $result) {
				$language_data[$result['code']] = [
					'id'          => $result['id'],
					'name'        => $result['name'],
					'code'        => $result['code'],
					'locale'      => $result['locale'],
					'image'       => $result['image'],
					'directory'   => $result['directory'],
					'sort_order'  => $result['sort_order'],
					'status'      => $result['status']
				];
			}

			$this->cache->set('language', json_encode($language_data));
		}

		return $language_data;
	}
}
