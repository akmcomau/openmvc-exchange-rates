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
	"hooks" => [
		"checkout" => [
			"getSellPrice" => "classes\\Hooks",
			"getSellTotal" => "classes\\Hooks",
		]
	],
	"default_config" => [
		"secret" => "",
		"endpoint" => "http://apilayer.net/api/",
		"main_currency" => "AUD",
	]
];
