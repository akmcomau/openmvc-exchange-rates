<?php
$_MODULE = [
	"name" => "Exchange Rates",
	"description" => "Convert monetary values to different currencies, using currencylayer.com",
	"namespace" => "\\modules\\exchange_rates",
	"config_controller" => "administrator\\ExchangeRates",
	"hooks" => [
	],
	"controllers" => [
		"administrator\\ExchangeRates",
	],
	"default_config" => [
		"secret" => "",
		"endpoint" => "http://apilayer.net/api/",
		"main_currency" => "AUD",
	]
];
