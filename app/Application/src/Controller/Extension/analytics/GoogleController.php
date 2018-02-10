<?php

namespace Application\Extension\Analytics;

use Ions\Mvc\Controller;

class GoogleController extends Controller
{
    public function processAction() {
		return html_entity_decode($this->config->get('analytics_google_code'), ENT_QUOTES, 'UTF-8');
	}
}
