<?php

namespace modules\analytics\classes;

use core\classes\exceptions\RedirectException;
use core\classes\Hook;
use core\classes\Model;
use core\classes\Authentication;
use core\classes\models\Customer;
use core\classes\models\Administrator;

class Hooks extends Hook {
	public function after_request($response_time) {
		// ignore robots
		if ($this->config->is_robot) return;

		// create the model objects
		$model = new Model($this->config, $this->database);
		$analytics_session = $model->getModel('\modules\analytics\classes\models\AnalyticsSession');
		$analytics_request = $model->getModel('\modules\analytics\classes\models\AnalyticsRequest');
		$analytics_user_agent = $model->getModel('\modules\analytics\classes\models\AnalyticsUserAgent');
		$analytics_referer = $model->getModel('\modules\analytics\classes\models\AnalyticsReferer');
		$analytics_campaign = $model->getModel('\modules\analytics\classes\models\AnalyticsCampaign');

		// check if a session already exists
		$session = $analytics_session->get([
			'php_id' => session_id()
		]);
		if (!$session) {
			// create the session
			$session = $analytics_session->getModel();
			$session->php_id = session_id();
			$session->ip = $request->serverParam('REMOTE_ADDR');

			// get the campaign
			if ($his->request->getParam('utm_source')) {
				// lookup campaign
				$campaign = $analytics_campaign->get([
					'source' => $his->request->getParam('utm_source'),
					'medium' => $his->request->getParam('utm_medium'),
					'campaign' => $his->request->getParam('utm_campaign'),
					'term' => $his->request->getParam('utm_term'),
				]);

				// create the user agent
				if (!$campaign) {
					$campaign = $analytics_campaign->getModel();
					$campaign->source = $his->request->getParam('utm_source') ?: '';
					$campaign->medium = $his->request->getParam('utm_medium') ?: '';
					$campaign->campaign = $his->request->getParam('utm_campaign') ?: '';
					$campaign->term = $his->request->getParam('utm_term') ?: '';
					$campaign->insert();
				}

				// increment the counter
				$campaign->increment();
				$session->analytics_campaign_id = $campaign->id;
			}

			// get the user agent
			$http_user_agent = $request->serverParam('HTTP_USER_AGENT');
			if ($http_user_agent) {
				$user_agent->$analytics_user_agent->get([
					'string' => $http_user_agent,
				]);
				if (!$user_agent) {
					$user_agent = $analytics_user_agent->getModel();
					$user_agent->string = $http_user_agent;
					$user_agent->insert();
				}

				$user_agent->increment();
				$session->referer_id = $referer->id;
			}

			// is there a referer
			$http_referer = $request->serverParam('HTTP_REFERER');
			if ($http_referer) {
				$referer->$analytics_referer->get([
					'url' => $http_referer,
				]);
				if (!$referer) {
					// parse the url
					$url = parse_url($http_referer);
					if ($url) {
						$referer = $analytics_referer->getModel();
						$referer->url = $http_referer;
						$referer->domain = $url["host"];
						$referer->insert();
					}
				}

				if ($referer) {
					$referer->increment();
					$session->referer_id = $referer->id;
				}
			}

			// create the session record
			$session->insert();
		}

		// increment the session hit counter
		$session->increment();

		// insert a request record
		$request = $analytics_request->getModel();
		$request->anaytics_session_id = $session_id;
		$request->controller = $this->request->getControllerName();
		$request->method = $this->request->getMethodName();
		$request->params = json_encode($this->request->getMethodParams());
		$request->response_time = (int)($response_time * 1000000);
		$request->insert();
	}
}
