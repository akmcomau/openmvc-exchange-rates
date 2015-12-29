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
			"BRL" => "BR",
			"CAD" => "CA",
			"CHF" => "CH",
			"CNY" => "CN",
			"EUR" => "DE",
			"GBP" => "GB",
			"HKD" => "HK",
			"IDR" => "ID",
			"INR" => "IN",
			"JPY" => "JP",
			"KRW" => "KR",
			"KWD" => "KW",
			"AED" => "AE",
			"MXN" => "MX",
			"MYR" => "MY",
			"NOK" => "NO",
			"NZD" => "NZ",
			"SAR" => "SA",
			"SEK" => "SE",
			"SGD" => "SG",
			"THB" => "TH",
			"TRY" => "TR",
			"TWD" => "TW",
			"USD" => "US",
			"VND" => "VN",
			"SAR" => "SA",
			"ARS" => "AR",
		],
	]
];
