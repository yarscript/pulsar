<?php

namespace Admin\Design;

use Ions\Mvc\Model;


class LayoutModel extends Model
{
    public function addLayout($data)
    {
        $this->db->execute("INSERT INTO layout SET name = " . $this->db->escape($data['name']));

        $id = $this->db->getLastId();

        if (isset($data['layout_route'])) {
            foreach ($data['layout_route'] as $layout_route) {
                $this->db->execute("INSERT INTO layout_route SET layout_id = '" . (int)$id . "', route = " . $this->db->escape($layout_route['route']));
            }
        }

        if (isset($data['layout_module'])) {
            foreach ($data['layout_module'] as $layout_module) {
                $this->db->execute("INSERT INTO layout_module SET layout_id = '" . (int)$id . "', code = " . $this->db->escape($layout_module['code']) . ", position = " . $this->db->escape($layout_module['position']) . ", sort_order = '" . (int)$layout_module['sort_order'] . "'");
            }
        }

        return $id;
    }

    public function editLayout($id, $data)
    {
        $this->db->execute("UPDATE layout SET `name` = " . $this->db->escape($data['name']) . " WHERE id = '" . (int)$id . "'");

        $this->db->execute("DELETE FROM layout_route WHERE layout_id = '" . (int)$id . "'");

        if (isset($data['layout_route'])) {
            foreach ($data['layout_route'] as $layout_route) {
                $this->db->execute("INSERT INTO layout_route SET layout_id = '" . (int)$id . "', route = " . $this->db->escape($layout_route['route']));
            }
        }

        $this->db->execute("DELETE FROM layout_module WHERE layout_id = '" . (int)$id . "'");

        if (isset($data['layout_module'])) {
            foreach ($data['layout_module'] as $layout_module) {
                $this->db->execute("INSERT INTO layout_module SET layout_id = '" . (int)$id . "', code = " . $this->db->escape($layout_module['code']) . ", position = " . $this->db->escape($layout_module['position']) . ", sort_order = '" . (int)$layout_module['sort_order'] . "'");
            }
        }
    }

    public function deleteLayout($id)
    {
        $this->db->execute("DELETE FROM layout WHERE id = '" . (int)$id . "'");
        $this->db->execute("DELETE FROM layout_route WHERE layout_id = '" . (int)$id . "'");
        $this->db->execute("DELETE FROM layout_module WHERE layout_id = '" . (int)$id . "'");
    }

    public function getLayout($id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM layout WHERE id = '" . (int)$id . "'");

        return $query->row;
    }

    public function getLayouts($data = [])
    {
        $sql = 'SELECT * FROM layout ORDER BY `name`';

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= ' LIMIT ' . (int)$data['start'] . ',' . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getLayoutRoutes($id)
    {
        $query = $this->db->query("SELECT * FROM layout_route WHERE layout_id = '" . (int)$id . "'");

        return $query->rows;
    }

    public function getLayoutModules($id)
    {
        $query = $this->db->query("SELECT * FROM layout_module WHERE layout_id = '" . (int)$id . "' ORDER BY `position` ASC, sort_order ASC");

        return $query->rows;
    }

    public function getTotalLayouts()
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM `layout`');

        return $query->row['total'];
    }
}
