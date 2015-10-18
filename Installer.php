<?php

namespace modules\exchange_rates;

use ErrorException;
use core\classes\Config;
use core\classes\Database;
use core\classes\Language;
use core\classes\Model;
use core\classes\Menu;

class Installer {
	protected $config;
	protected $database;

	public function __construct(Config $config, Database $database) {
		$this->config = $config;
		$this->database = $database;
	}

	public function install() {
		$model = new Model($this->config, $this->database);

		$table = $model->getModel('\\modules\\exchange_rates\\classes\\models\\ExchangeRate');
		$table->createTable();
		$table->createIndexes();
		$table->createForeignKeys();
	}

	public function uninstall() {
		$model = new Model($this->config, $this->database);

		$table = $model->getModel('\\modules\\exchange_rates\\classes\\models\\ExchangeRate');
		$table->dropTable();
	}

	public function enable() {
		$language = new Language($this->config);
		$language->loadLanguageFile('administrator/exchange_rates.php', DS.'modules'.DS.'exchange_rates');

		$layout_strings = $language->getFile('administrator/layout.php');
		$layout_strings['module_exchange_rates'] = $language->get('module_exchange_rates');
		$language->updateFile('administrator/layout.php', $layout_strings);

		$main_menu = new Menu($this->config, $language);
		$main_menu->loadMenu('menu_admin_main.php');
		$main_menu->insert_menu(['content', 'file_manager'], 'exchange_rates', [
			'controller' => 'administrator/ExchangeRates',
			'method' => 'index',
			'text_tag' => 'module_exchange_rates',
		]);
		$main_menu->update();
	}

	public function disable() {
		$language = new Language($this->config);

		$layout_strings = $language->getFile('administrator/layout.php');
		unset($layout_strings['module_exchange_rates']);
		$language->updateFile('administrator/layout.php', $layout_strings);

		// Remove some menu items to the admin menu
		$main_menu = new Menu($this->config, $language);
		$main_menu->loadMenu('menu_admin_main.php');
		$menu = $main_menu->getMenuData();
		unset($menu['content']['children']['exchange_rates']);
		$main_menu->setMenuData($menu);
		$main_menu->update();
	}
}
