<?php

namespace Admin\Tool;

use Ions\Mvc\Model;

class ImageModel extends Model
{
    public function resize($filename, $width, $height)
    {
        if (!is_file($this->image->getDirectory() . DIRECTORY_SEPARATOR . $filename)) {
            return null;
        }

        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $image_old = $filename;
        $image_new = 'cache' . DIRECTORY_SEPARATOR . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

        if (!is_file($this->image->getDirectory() . DIRECTORY_SEPARATOR . $image_new) || (filemtime($this->image->getDirectory() . DIRECTORY_SEPARATOR . $image_old) > filemtime($this->image->getDirectory() . DIRECTORY_SEPARATOR . $image_new))) {
            list($width_orig, $height_orig, $image_type) = getimagesize($this->image->getDirectory() . DIRECTORY_SEPARATOR . $image_old);

            if (!in_array($image_type, [IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF], true)) {
                return $this->image->getDirectory() . DIRECTORY_SEPARATOR . $image_old;
            }

            $path = '';

            $directories = explode(DIRECTORY_SEPARATOR, dirname($image_new));

            foreach ($directories as $directory) {
                $path = $path . DIRECTORY_SEPARATOR . $directory;

                if (!is_dir($this->image->getDirectory() . DIRECTORY_SEPARATOR . $path)) {
                    @mkdir($this->image->getDirectory() . DIRECTORY_SEPARATOR . $path, 0777);
                }
            }

            if ($width_orig != $width || $height_orig != $height) {
                $this->image->load($image_old);
                $this->image->resize($width, $height);
                $this->image->save($this->image->getDirectory() . DIRECTORY_SEPARATOR . $image_new);
            } else {
                copy($this->image->getDirectory() . DIRECTORY_SEPARATOR . $image_old, $this->image->getDirectory() . DIRECTORY_SEPARATOR . $image_new);
            }
        }

        return 'img' . DIRECTORY_SEPARATOR . $image_new;

    }
}
