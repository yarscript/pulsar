<?php

namespace Application\Design;

use Ions\Mvc\Model;

class LayoutModel extends Model
{
    public function getLayout($route)
    {
        $query = $this->db->query("SELECT * FROM layout_route WHERE " . $this->db->escape($route) . " LIKE route ORDER BY route DESC LIMIT 1");

        if ($query->count) {
            return (int)$query->row['layout_id'];
        }

        return 0;
    }

    public function getLayoutModules($layout_id, $position)
    {
        $query = $this->db->query("SELECT * FROM layout_module WHERE layout_id = '" . (int)$layout_id . "' AND position = " . $this->db->escape($position) . " ORDER BY sort_order");

        return $query->rows;
    }
}
