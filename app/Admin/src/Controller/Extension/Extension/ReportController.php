<?php
namespace Admin\Extension\Extension;

use Ions\Mvc\Controller;

class ReportController extends Controller
{
    private $error = [];

    public function indexAction()
    {
        $this->language->load('extension/extension/report');

        $this->getList();
    }

    public function installAction()
    {
        $this->language->load('extension/extension/report');

        if ($this->validate()) {
            $this->model('setting/extension')->install('report', $this->request->getQuery('extension'));

            $this->model('user/group')->addPermission($this->user->getGroupId(), 'access', 'admin/extension/report/' . $this->request->getQuery('extension'));
            $this->model('user/group')->addPermission($this->user->getGroupId(), 'modify', 'admin/extension/report/' . $this->request->getQuery('extension'));

            $this->controller('extension/report/' . $this->request->getQuery('extension') . '/install');

            $this->session->set('success', $this->language->get('text_success'));
        }

        $this->getList();
    }

    public function uninstallAction()
    {
        $this->language->load('extension/extension/report');

        if ($this->validate()) {
            $this->model('setting/extension')->uninstall('report', $this->request->getQuery('extension'));

            $this->controller('extension/report/' . $this->request->getQuery('extension'). '/uninstall');

            $this->session->set('success', $this->language->get('text_success'));
        }

        $this->getList();
    }

    protected function getList()
    {
        if ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        if ($this->session->has('success')) {
            $data['success'] = $this->session->get('success');

            $this->session->delete('success');
        } else {
            $data['success'] = '';
        }

        $extensions = $this->model('setting/extension')->getInstalled('report');

        foreach ($extensions as $key => $value) {
            if (!is_file('app/' . $this->app->getName() . '/src/Controller/Extension/Report/' . $value . '.php') && !is_file($this->app->getDirectory() . '/controller/report/' . $value . '.php')) {
                $this->model('setting/extension')->uninstall('report', $value);

                unset($extensions[$key]);
            }
        }

        $data['extensions'] = [];

        // Compatibility code for old extension folders
        $files = glob('app/' . $this->app->getName() . '/src/Controller/Extension/Report/*.php');

        if ($files) {
            foreach ($files as $file) {
                $extension = strtolower(basename($file, 'Controller.php'));

                $this->language->load('extension/report/' . $extension, 'extension');

                $data['extensions'][] = [
                    'name' => $this->language->get('extension')->get('heading_title'),
                    'status' => $this->config->get('report_' . $extension . '_status') ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
                    'sort_order' => $this->config->get('report_' . $extension . '_sort_order'),
                    'install' => $this->url->link('extension/extension/report/install', 'token=' . $this->session->get('token') . '&extension=' . $extension),
                    'uninstall' => $this->url->link('extension/extension/report/uninstall', 'token=' . $this->session->get('token') . '&extension=' . $extension),
                    'installed' => in_array($extension, $extensions, true),
                    'edit' => $this->url->link('extension/report/' . $extension, 'token=' . $this->session->get('token'))
                ];
            }
        }

        $this->response->setContent($this->view('extension/extension/report', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/extension/report')) {
            $this->error = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}
