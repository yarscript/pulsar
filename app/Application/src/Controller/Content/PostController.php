<?php

namespace Application\Content;

use Ions\Mvc\Controller;

class PostController extends Controller
{
	public function indexAction() {
		$this->language->load('content/post');

		if ($this->request->hasQuery('id')) {
			$id = (int)$this->request->getQuery('id');
		} else {
			$id = 0;
		}

		$post_info = $this->model('content/post')->getPost($id);

		if ($post_info) {
			$this->document->setTitle($post_info['meta_title']);
			$this->document->setDescription($post_info['meta_description']);
			$this->document->setKeywords($post_info['meta_keyword']);
			$this->document->addLink($this->url->link('content/post', 'id=' . $this->request->getQuery('id')), 'canonical');

			$data['heading_title'] = $post_info['name'];

			$data['id'] = (int)$this->request->getQuery('id');
			$data['description'] = html_entity_decode($post_info['description'], ENT_QUOTES, 'UTF-8');
            $data['author'] = $post_info['author'];
            $data['date'] = $post_info['date'];
            $data['ago'] = $post_info['ago'];
            $data['image'] = 'img'.$post_info['image'];

			$data['relateds'] = $this->model('content/post')->getPostRelated($id);




			$data['tags'] = [];

			if ($post_info['tag']) {
				$tags = explode(',', $post_info['tag']);

				foreach ($tags as $tag) {
					$data['tags'][] = [
						'tag'  => trim($tag),
						'href' => $this->url->link('content/search', 'tag=' . trim($tag))
					];
				}
			}

			$this->model('content/post')->updateViewed($this->request->getQuery('id'));

			$data['column_left'] = $this->controller('column_left');
			$data['column_right'] = $this->controller('column_right');
			$data['content_top'] = $this->controller('content_top');
			$data['content_bottom'] = $this->controller('content_bottom');
			$data['footer'] = $this->controller('footer');
			$data['header'] = $this->controller('header');

			$this->response->setContent($this->view('content/post', $data));
		} else {
            $this->language->load('error/not_found');
            $data['heading_title'] = $this->language->get('text_error');

			//$this->response->addHeader($this->request->server['SERVER_PROTOCOL'], ' 404 Not Found');

			$data['column_left'] = $this->controller('column_left');
			$data['column_right'] = $this->controller('column_right');
			$data['content_top'] = $this->controller('content_top');
			$data['content_bottom'] = $this->controller('content_bottom');
			$data['footer'] = $this->controller('footer');
			$data['header'] = $this->controller('header');

			$this->response->setContent($this->view('error/not_found', $data));
		}
	}
}
