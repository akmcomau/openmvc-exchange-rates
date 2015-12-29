<?php

namespace modules\exchange_rates\classes;

use core\classes\exceptions\RedirectException;
use core\classes\Hook;
use core\classes\Model;
use modules\exchange_rates\classes\models\ExchangeRate;

class Hooks extends Hook {
	public function getSellPrice($price) {
		$model = new Model($this->config, $this->database);
		$exchange_rate = $model->getModel('modules\exchange_rates\classes\models\ExchangeRate');
		return $exchange_rate->convert($this->config->siteConfig()->currency, $price);
	}

	public function getSellTotal($price) {
		return $this->getSellPrice($price);
	}

	public function getExchangeRate() {
		$model = new Model($this->config, $this->database);
		$exchange_rate = $model->getModel('modules\exchange_rates\classes\models\ExchangeRate');
		return $exchange_rate->convert($this->config->siteConfig()->currency, 1);
	}
}
