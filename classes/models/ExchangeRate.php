<?php

namespace modules\exchange_rates\classes\models;

use core\classes\exceptions\RedirectException;
use core\classes\Hook;
use core\classes\Model;
use core\classes\Module;
use core\classes\Authentication;
use core\classes\models\Customer;
use core\classes\models\Administrator;

class ExchangeRate extends Model {
	protected $table       = 'exchange_rate';
	protected $primary_key = 'exchange_rate_id';
	protected $columns     = [
		'exchange_rate_id' => [
			'data_type'      => 'int',
			'auto_increment' => TRUE,
			'null_allowed'   => FALSE,
		],
		'exchange_rate_currency' => [
			'data_type'      => 'text',
			'data_length'    => 3,
			'null_allowed'   => FALSE,
		],
		'exchange_rate_value' => [
			'data_type'      => 'numeric',
			'data_length'    => [10, 6],
			'null_allowed'   => TRUE,
		],
	];

	protected $indexes = [
		'exchange_rate_currency',
	];

	protected $uniques = [
		'exchange_rate_currency',
	];

	public function convert($to, $value) {
		$to = $this->getRate($to);
		return $value * $to->value;
	}

	public function getRate($name) {
		if (!isset(self::$static_objects[$name])) {
			self::$static_objects[$name] = $this->get([
				'currency' => $name
			]);
		}

		return self::$static_objects[$name];
	}

	public function getAllRates() {
		if (!isset($this->objects['all_rates'])) {
			$this->objects['all_rates'] = $this->getMulti([], ['currency' => 'asc']);
		}

		return $this->objects['all_rates'];
	}

	public function updateRates() {
		$module_config = $this->config->moduleConfig('\modules\exchange_rates');
		$endpoint = $module_config->endpoint;
		$secret = $module_config->secret;

		$json = file_get_contents($endpoint.'live?access_key='.$secret);
		$rates = json_decode($json);

		$source = $rates->source;
		$main_rate_name = $source.$module_config->main_currency;
		if (!property_exists($rates->quotes, $main_rate_name)) {
			$this->logger->error('Cannot find main exchange rate');
			return;
		}

		$main_rate = $rates->quotes->$main_rate_name;
		$exchange_rates = [$source => $main_rate];
		foreach ($rates->quotes as $currency => $rate) {
			$currency = substr($currency, 3);
			$exchange_rates[$currency] = $rate / $main_rate;
		}

		foreach ($exchange_rates as $currency => $rate) {
			$db_rate = $this->get(['currency' => $currency]);
			if ($db_rate) {
				$db_rate->value = $rate;
				$db_rate->update();
			}
			else {
				$db_rate = $this->getModel(__CLASS__);
				$db_rate->currency = $currency;
				$db_rate->value = $rate;
				$db_rate->insert();
			}
		}
	}
}
