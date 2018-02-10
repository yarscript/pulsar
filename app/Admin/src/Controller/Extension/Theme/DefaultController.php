<?php
namespace Admin\Extension\Theme;

use Ions\Mvc\Controller;

class DefaultController extends Controller
{
    private $error = [];

    public function indexAction()
    {
        $this->language->load('extension/theme/default');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validate()) {

            $data = $this->request->getPost();
            $data['theme_default_class'] = implode(' ', $data['theme_default_class']);

            $this->model('system/setting')->editSetting('theme_default', $data);

            $this->session->set('success', $this->language->get('text_success'));

            $this->response->redirect($this->url->link('extension/extension/theme', 'token=' . $this->session->get('token'). '&type=theme'));
        }

        if ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_dashboard'),
            'href' => $this->url->link('dashboard', 'token=' . $this->session->get('token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension/theme', 'token=' . $this->session->get('token'). '&type=theme')
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' =>''
        ];

        $data['action'] = $this->url->link('extension/theme/default', 'token=' . $this->session->get('token'));
        $data['cancel'] = $this->url->link('extension/extension/theme', 'token=' . $this->session->get('token'). '&type=theme');

        if (!$this->request->isPost()) {
            $setting_info =  $this->model('system/setting')->getSetting('theme_default');
        }

        if ($this->request->hasPost('theme_default_status')) {
            $data['theme_default_status'] = true;
        } elseif (isset($setting_info['theme_default_status'])) {
            $data['theme_default_status'] = $setting_info['theme_default_status'];
        } else {
            $data['theme_default_status'] = false;
        }

        if ($this->request->hasPost('theme_default_class')) {
            $data['theme_default_class'] = implode(' ', $data['theme_default_class']);
        } elseif (isset($setting_info['theme_default_class'])) {
            $data['theme_default_class'] = $setting_info['theme_default_class'];
        } else {
            $data['theme_default_class'] = '';
        }

        if ($this->request->hasPost('theme_default_theme')) {
            $data['theme_default_theme'] = $this->request->getPost('theme_default_theme');
        } elseif (isset($setting_info['theme_default_theme'])) {
            $data['theme_default_theme'] = $setting_info['theme_default_theme'];
        } else {
            $data['theme_default_theme'] = '';
        }

        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');

        $this->response->setContent($this->view('extension/theme/default', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/theme/default')) {
            $this->error = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function installAction()
    {
    }

    public function uninstallAction()
    {
    }
}
