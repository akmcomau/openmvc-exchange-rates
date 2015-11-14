<?php

namespace modules\exchange_rates\controllers\administrator;

use core\classes\exceptions\RedirectException;
use core\classes\exceptions\SoftRedirectException;
use core\classes\renderable\Controller;
use core\classes\Model;
use core\classes\Pagination;
use core\classes\FormValidator;

class ExchangeRates extends Controller {

	protected $show_admin_layout = TRUE;

	protected $permissions = [
		'config' => ['administrator'],
		'index' => ['administrator'],
		'updateRates' => ['administrator'],
	];

	public function config() {

	}

	public function index() {
		$model = new Model($this->config, $this->database);
		$exchange_rates = $model->getModel('\modules\exchange_rates\classes\models\ExchangeRate');

		$data = [
			'rates' => $exchange_rates->getAllRates(),
		];

		$template = $this->getTemplate('pages/administrator/list_rates.php', $data, 'modules/exchange_rates');
		$this->response->setContent($template->render());
	}

	public function updateRates() {
		$model = new Model($this->config, $this->database);
		$exchange_rates = $model->getModel('\modules\exchange_rates\classes\models\ExchangeRate');
		$exchange_rates->updateRates();

		$data = [
			'rates' => $exchange_rates->getAllRates(),
		];

		$template = $this->getTemplate('pages/administrator/updated_rates.php', $data, 'modules/exchange_rates');
		$this->response->setContent($template->render());
	}

}
