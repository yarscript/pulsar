<?php
/**
 * Ions Framework (http://ionscript.com/)
 *
 *  @link      http://github.com/ionscript/ionscript for the canonical source repository
 *  @copyright Copyright (c) 2017 Ions Technologies UA Inc. (http://www.ionscript.com)
 *  @license   http://github.com/ionscript/ionscript/LICENSE.md GPL-3.0+ License
 *  @author    Serge Shportko (ionscript.inc@gmail.com)
 */

namespace Application\Setting;

use Ions\Mvc\Model;

class ModuleModel extends Model
{
	public function getModule($module_id) {
		$query = $this->db->query("SELECT * FROM module WHERE id = " . (int)$module_id);
		
		if ($query->row) {
			return json_decode($query->row['setting'], true);
		}

		return [];
	}		
}
