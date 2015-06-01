<?php

if (!defined("IN_ESOTALK")) exit;

ET::$pluginInfo["Favicon"] = array(
	"name" => "Favicon",
	"description" => "Adds a favicon",
	"version" => "0.1",
	"author" => "Syfaro",
	"authorEmail" => "sy@syfaro.net",
	"authorURL" => "https://blog.syfaro.net",
	"license" => "MIT",
	"dependencies" => array("esoTalk" => "1.0.0g4")
);

class ETPlugin_Favicon extends ETPlugin {
	public function handler_init($sender) {
		$faviconPath = C('plugin.Favicon.path');

		if ($faviconPath)
			$faviconCode = "<link rel='shortcut icon' href='{$faviconPath}'>";

		$sender->addToHead($faviconCode);
	}

	public function settings($sender) {
		$form = ETFactory::make('form');
		$form->action = URL('admin/plugins/settings/Favicon');
		$form->setValue('path', C('plugin.Favicon.path'));

		if ($form->validPostBack('FaviconSave')) {
			$config = array();
			$config['plugin.Favicon.path'] = trim($form->getValue('path'));

			if (!$form->errorCount()) {
				ET::writeConfig($config);

				$sender->message(T('message.changesSaved'), 'success');
				$sender->redirect(URL('admin/plugins'));
			}
		}

		$sender->data('FaviconForm', $form);
		return $this->view('settings');
	}
}
