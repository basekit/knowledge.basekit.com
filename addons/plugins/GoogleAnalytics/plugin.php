<?php
// Copyright 2013 ciruz
if (!defined("IN_ESOTALK")) exit;

ET::$pluginInfo["GoogleAnalytics"] = array(
	"name" => "Google Analytics",
	"description" => "Adds Google Analytics.",
	"version" => "0.2",
	"author" => "ciruz",
	"authorEmail" => "me@ciruz.net",
	"authorURL" => "http://www.ciruz.net",
	"license" => "MIT",
	"dependencies" => array("esoTalk" => "1.0.0g4")
);

class ETPlugin_GoogleAnalytics extends ETPlugin{

	public function handler_init($sender){
		$propertyId = C('plugin.GoogleAnalytics.propertyId');

		if($propertyId)
			$analyticsCode = "<script>\n (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){\n (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),\n m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)\n })(window,document,'script','//www.google-analytics.com/analytics.js','ga');\n\n ga('create', '".$propertyId."', 'auto');\n ga('send', 'pageview');\n</script>";

		$sender->addToHead($analyticsCode);
	}

	public function settings($sender){
		$form = ETFactory::make('form');
		$form->action = URL('admin/plugins/settings/GoogleAnalytics');
		$form->setValue("propertyId", C("plugin.GoogleAnalytics.propertyId"));

		if ($form->validPostBack('GoogleAnalyticsSave')){
			$config = array();
			$config['plugin.GoogleAnalytics.propertyId'] = trim($form->getValue('propertyId'));

			if (!$form->errorCount()) {
				ET::writeConfig($config);

				$sender->message(T('message.changesSaved'), 'success');
				$sender->redirect(URL('admin/plugins'));
			}
		}

		$sender->data('GoogleAnalyticsForm', $form);
		return $this->view('settings');
	}

}