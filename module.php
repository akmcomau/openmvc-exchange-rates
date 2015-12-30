<?php
$_MODULE = [
	"name" => "Exchange Rates",
	"description" => "Convert monetary values to different currencies, using currencylayer.com",
	"namespace" => "\\modules\\exchange_rates",
	"config_controller" => "administrator\\ExchangeRates",
	"hooks" => [
	],
	"controllers" => [
		"ExchangeRates",
		"administrator\\ExchangeRates",
	],
	"hooks" => [
		"checkout" => [
			"getSellPrice"    => "classes\\Hooks",
			"getSellTotal"    => "classes\\Hooks",
			"getExchangeRate" => "classes\\Hooks",
		]
	],
	"default_config" => [
		"secret" => "",
		"endpoint" => "http://apilayer.net/api/",
		"main_currency" => "AUD",
		"mapping" => [
			"AUD" => "AU",
			"GBP" => "GB",
			"CAD" => "CA",
			"CZK" => "CZ",
			"DKK" => "DK",
			"EUR" => "DE",
			"HKD" => "HK",
			"HUF" => "HU",
			"ILS" => "IL",
			"JPY" => "JP",
			"MXN" => "MX",
			"TWD" => "TW",
			"NZD" => "NZ",
			"NOK" => "NO",
			"PHP" => "PH",
			"PLN" => "PL",
			"RUB" => "RU",
			"SGD" => "SG",
			"SEK" => "SE",
			"CHF" => "CH",
			"THB" => "TH",
			"USD" => "US",
		],
	]
];
