<?php
namespace Admin\Report;

use Ions\Mvc\Service\Pagination;
use Ions\Mvc\Controller;

class OnlineController extends Controller
{
	public function indexAction() {
		$this->language->load('report/online');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_dashboard'),
			'href' => $this->url->link('dashboard', 'token=' . $this->session->get('token'))
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('online', 'token=' . $this->session->get('token'))
		];
		
		$data['refresh'] = $this->url->link('online', 'token=' . $this->session->get('token'));

		$data['users'] = [];

		$options = [
			'start'           => ($page - 1) * $this->config->get('config_limit'),
			'limit'           => $this->config->get('config_limit')
		];

		$total = $this->model('report/online')->getTotalOnline($options);

		$results = $this->model('report/online')->getOnline($options);

		foreach ($results as $result) {
			$user_info = $this->model('user/user')->getUser($result['user_id']);

			if ($user_info) {
				$user = $user_info['firstname'] . ' ' . $user_info['lastname'];
			} else {
				$user = $this->language->get('text_guest');
			}

			$data['users'][] = [
				'user_id'     => $result['user_id'],
				'ip'          => $result['ip'],
				'user'        => $user,
				'url'         => $result['url'],
				'referer'     => $result['referer'],
				'date_added'  => date($this->language->get('datetime_format'), strtotime($result['date_added'])),
				'edit'        => $this->url->link('user/edit', 'token=' . $this->session->get('token') . '&id=' . $result['user_id'])
			];
		}

		$pagination = new Pagination();
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit');
		$pagination->url = $this->url->link('online', 'token=' . $this->session->get('token') . '&page={page}');

		$data['pagination'] = $pagination->render();

        $data['results'] = $pagination->renderResult($this->language->get('text_pagination'));

        $data['total'] = $total;

        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');
		
		$this->response->setContent($this->view('report/online', $data));
	}

    public function installAction()
    {
    }

    public function uninstallAction()
    {
    }
}
