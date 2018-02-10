<?php

namespace Application\Design;

use Ions\Mvc\Model;

class BannerModel extends Model
{
    public function getBanner($id)
    {
        $query = $this->db->query("SELECT * FROM banner b LEFT JOIN banner_image bi ON (b.id = bi.banner_id) WHERE b.id = '" . (int)$id . "' AND b.status = '1' AND bi.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY bi.sort_order ASC");
        return $query->rows;
    }
}
