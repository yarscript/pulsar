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

class ExtensionModel extends Model
{
	public function getExtensions($type) {
		$query = $this->db->query("SELECT * FROM extension WHERE `type` = " . $this->db->escape($type));

		return $query->rows;
	}
}
