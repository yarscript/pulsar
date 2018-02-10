<?php

namespace Application\Account;

use Ions\Mvc\Model;

class SearchModel extends Model
{
	public function addSearch($data) {
		$this->db->execute("INSERT INTO `user_search` SET `language_id` = '" . (int)$this->config->get('config_language_id') . "', `user_id` = '" . (int)$data['user_id'] . "', `keyword` = " . $this->db->escape($data['keyword']) . ", `category_id` = '" . (int)$data['category_id'] . "', `sub_category` = '" . (int)$data['sub_category'] . "', `description` = '" . (int)$data['description'] . "', `posts` = '" . (int)$data['posts'] . "', `ip` = " . $this->db->escape($data['ip']) . ", `date_added` = NOW()");
	}
}
