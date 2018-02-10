<?php
namespace Application\Content;

use Ions\Mvc\Model;

class CategoryModel extends Model
{
	public function getCategory($id) {
		$query = $this->db->query("SELECT DISTINCT * FROM category c LEFT JOIN category_description cd ON (c.id = cd.category_id) WHERE c.id = '" . (int)$id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.status = '1'");

		return $query->row;
	}

	public function getCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM category c LEFT JOIN category_description cd ON (c.id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");

		return $query->rows;
	}
	
	public function getTotalCategoriesByCategoryId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM category c WHERE c.parent_id = '" . (int)$parent_id . "' AND c.status = '1'");

		return $query->row['total'];
	}
}
