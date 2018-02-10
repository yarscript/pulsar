<?php
/**
 * Ions Framework (http://ionscript.com/)
 *
 * @link      http://github.com/ionscript/ionscript for the canonical source repository
 * @copyright Copyright (c) 2017 Ions Technologies UA Inc. (http://www.ionscript.com)
 * @license   http://github.com/ionscript/ionscript/LICENSE.md GPL-3.0+ License
 * @author    Serge Shportko (ionscript.inc@gmail.com)
 */

namespace Application\Tool;

use Ions\Mvc\Model;

class ImageModel extends Model
{
    public function resize($filename, $width, $height)
    {
        if (!is_file($this->image->getDirectory() .'/'. $filename)) {
            return null;
        }

        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $image_old = $filename;
        $image_new = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

        if (!is_file($this->image->getDirectory() .'/'. $image_new) || (filemtime($this->image->getDirectory() .'/'. $image_old) > filemtime($this->image->getDirectory() .'/'. $image_new))) {
            list($width_orig, $height_orig, $image_type) = getimagesize($this->image->getDirectory() .'/'. $image_old);

            if (!in_array($image_type, [IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF])) {
                return $this->image->getDirectory() .'/'. $image_old;
            }

            $path = '';

            $directories = explode('/', dirname($image_new));

            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;

                if (!is_dir($this->image->getDirectory() .'/'. $path)) {
                    @mkdir($this->image->getDirectory() .'/'. $path, 0777);
                }
            }

            if ($width_orig != $width || $height_orig != $height) {
                $this->image->load($image_old);
                $this->image->resize($width, $height);
                $this->image->save($this->image->getDirectory() .'/'. $image_new);
            } else {
                copy($this->image->getDirectory() .'/'. $image_old, $this->image->getDirectory() .'/'. $image_new);
            }
        }

//        if ($this->request->server['HTTPS']) {
//            return HTTPS_APPLICATION . 'img/' . $image_new;
//        } else {
//            return HTTP_APPLICATION. 'img/' . $image_new;
//        }


        return $this->url->link('img/' . $image_new);

    }
}
