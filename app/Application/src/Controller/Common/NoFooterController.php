<?php
/**
 * Ions Framework (http://ionscript.com/)
 *
 *  @link      http://github.com/ionscript/ionscript for the canonical source repository
 *  @copyright Copyright (c) 2017 Ions Technologies UA Inc. (http://www.ionscript.com)
 *  @license   http://github.com/ionscript/ionscript/LICENSE.md GPL-3.0+ License
 *  @author    Serge Shportko (ionscript.inc@gmail.com)
 */

namespace Application\Common;

use Ions\Mvc\Controller;


class NoFooterController extends Controller
{
    public function indexAction()
    {
        $this->language->load('common/footer');

        // Whos Online
        if ($this->config->get('config_user_online')) {
            if ($this->request->hasServer('REMOTE_ADDR')) {
                $ip = $this->request->getServer('REMOTE_ADDR');
            } else {
                $ip = '';
            }

            if ($this->request->hasServer('HTTP_HOST') && $this->request->hasServer('REQUEST_URI')) {
                $url = ($this->request->hasServer('HTTPS') ? 'https://' : 'http://') . $this->request->getServer('HTTP_HOST') . $this->request->getServer('REQUEST_URI');
            } else {
                $url = '';
            }

            if ($this->request->hasServer('HTTP_REFERER')) {
                $referer = $this->request->getServer('HTTP_REFERER');
            } else {
                $referer = '';
            }

            $this->model('tool/online')->addOnline($ip, $this->user->getId(), $url, $referer);
        }

        $this->document->addScript('js/app.js', 'footer');

        $data['scripts'] = $this->document->getScripts('footer');

        return $this->view('common/no_footer', $data);
    }
}
