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
	];

	public function config() {

	}

	public function index() {
		$model = new Model($this->config, $this->database);
		$exchange_rates = $model->getModel('\modules\exchange_rates\classes\models\ExchangeRate');
		$exchange_rates->updateRates();
	}

}
