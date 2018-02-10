<?php
namespace Admin\Design;

use Ions\Mvc\Model;


class BannerModel extends Model
{
    public function addBanner($data)
    {
        $this->db->execute('INSERT INTO banner SET name = ' . $this->db->escape($data['name']) . ", status = '" . (int)$data['status'] . "'");

        $banner_id = $this->db->getLastId();

        if (isset($data['banner_image'])) {
            foreach ($data['banner_image'] as $language_id => $value) {
                foreach ($value as $banner_image) {
                    $this->db->execute("INSERT INTO banner_image SET banner_id = '" . (int)$banner_id . "', language_id = '" . (int)$language_id . "', title = " . $this->db->escape($banner_image['title']) . ", link = " . $this->db->escape($banner_image['link']) . ", image = " . $this->db->escape($banner_image['image']) . ", sort_order = '" . (int)$banner_image['sort_order'] . "'");
                }
            }
        }

        return $banner_id;
    }

    public function editBanner($id, $data)
    {
        $this->db->execute("UPDATE banner SET `name` = " . $this->db->escape($data['name']) . ", `status` = '" . (int)$data['status'] . "' WHERE id = '" . (int)$id . "'");

        $this->db->execute("DELETE FROM banner_image WHERE banner_id = '" . (int)$id . "'");

        if (isset($data['image'])) {
            foreach ($data['image'] as $language_id => $value) {
                foreach ($value as $image) {
                    $this->db->execute("INSERT INTO banner_image SET banner_id = '" . (int)$id . "', language_id = '" . (int)$language_id . "', title = " . $this->db->escape($image['title']) . ", link = " . $this->db->escape($image['link']) . ", image = " . $this->db->escape($image['image']) . ", sort_order = '" . (int)$image['sort_order'] . "'");
                }
            }
        }
    }

    public function deleteBanner($id)
    {
        $this->db->execute("DELETE FROM banner WHERE id = '" . (int)$id . "'");
        $this->db->execute("DELETE FROM banner_image WHERE banner_id = '" . (int)$id . "'");
    }

    public function getBanner($id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM banner WHERE id = '" . (int)$id . "'");

        return $query->row;
    }

    public function getBanners($data = [])
    {
        $sql = 'SELECT * FROM banner ORDER BY name ASC';

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

    public function getBannerImages($banner_id)
    {
        $data = [];

        $query = $this->db->query("SELECT * FROM banner_image WHERE banner_id = '" . (int)$banner_id . "' ORDER BY sort_order ASC");

        foreach ($query->rows as $image) {
            $data[$image['language_id']][] = [
                'title' => $image['title'],
                'link' => $image['link'],
                'image' => $image['image'],
                'sort_order' => $image['sort_order']
            ];
        }

        return $data;
    }

    public function getTotalBanners()
    {
        $query = $this->db->query('SELECT COUNT(*) AS total FROM banner');

        return $query->row['total'];
    }
}
