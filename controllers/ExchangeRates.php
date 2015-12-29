<?php

namespace modules\exchange_rates\controllers;

use core\classes\exceptions\SoftRedirectException;
use core\classes\exceptions\RedirectException;
use core\classes\exceptions\TemplateException;
use core\classes\renderable\Controller;
use core\classes\Email;
use core\classes\URL;
use core\classes\FormValidator;

class ExchangeRates extends Controller {
	public function currency() {
		$this->language->loadLanguageFile('exchange_rates.php', 'modules/exchange_rates');
		$country = $this->model->getModel('\core\classes\models\Country');
		$exchange_rates = $this->model->getModel('\modules\exchange_rates\classes\models\ExchangeRate');
		$exchange_rate_config = $this->config->moduleConfig('\modules\exchange_rates');

		$currency_filter = function($country) use ($exchange_rate_config, $exchange_rates) {
			$currency = $country->currency;
			if (
				$currency &&
				$exchange_rates->getRate($currency) &&
				$this->language->exists('currency_'.strtolower($currency)) &&
				property_exists($exchange_rate_config->mapping, $currency) &&
				$exchange_rate_config->mapping->$currency == $country->code
			) {
				return TRUE;
			}
			return FALSE;
		};

		$data = [
			'currencies'  => $country->getCurrenciesByContinent($currency_filter),
			'request'     => $this->request,
		];

		$template = $this->getTemplate('pages/currency.php', $data, 'modules/exchange_rates');
		$this->response->setContent($template->render());
	}
}
