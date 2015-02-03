<?php
// Copyright 2014 Tristan van Bokkem

if (!defined("IN_ESOTALK")) exit;

ET::$pluginInfo["reCAPTCHA"] = array(
	"name" => "reCAPTCHA",
	"description" => "Protect your forum from spam and abuse while letting real people pass through with ease.",
	"version" => "1.1.2",
	"author" => "Tristan van Bokkem",
	"authorEmail" => "tristanvanbokkem@gmail.com",
	"authorURL" => "http://esotalk.org",
	"license" => "GPLv2",
	"dependencies" => array(
		"esoTalk" => "1.0.0g4"
	)
);


class ETPlugin_reCAPTCHA extends ETPlugin {

	public function setup()
	{
		// Don't enable this plugin if we are not running PHP >= 5.3.0.
		if (version_compare(PHP_VERSION, '5.3.0') < 0) {
			return "PHP >= 5.3.0 is required to enable this plugin.<br />However, you are running PHP ".PHP_VERSION;
		} else {
			return true;
		}
	}

	public function init()
	{
		// Include the Google reCAPTCHA library.
		require_once (PATH_PLUGINS."/reCAPTCHA/lib/recaptchalib.php");

		// Define default language definitions.
		ET::define("message.reCAPTCHARefreshInfo", "Click or tap on an image to refresh it.");
		ET::define("message.invalidCAPTCHA", "The CAPTCHA you entered is invalid. Please try again.");
		ET::define("message.reCAPTCHA.settings", "Enter your reCAPTCHA Keys (<a href='https://www.google.com/recaptcha/admin#whyrecaptcha' target='_blank'>Got no Keys yet? Get them here!</a>)");
		ET::define("mlarray.reCAPTCHA", array(
			"instructions_visual" => "Type the two words"
		));
	}

	public function handler_renderBefore($sender)
	{
		$sender->addCSSFile($this->resource("recaptcha.css"));
	}

	// Hook into the join function to include the reCAPTCHA form.
	public function handler_userController_initJoin($controller, $form)
	{
		if(C('plugin.reCAPTCHA.private') && C('plugin.reCAPTCHA.public')) {

			// Add the reCAPTCHA section.
			$form->addSection("recaptcha", T("Are you human?"));

			// Add the reCAPTCHA field.
			$form->addField("recaptcha", "recaptcha", array($this, "renderRecaptchaField"), array($this, "processRecaptchaField"));
		}
	}

	function renderRecaptchaField($form)
	{
		// Format the reCAPTCHA form with some JavaScript and HTML
		// retrieved from the Google reCAPTCHA library.
	    return "<script type='text/javascript'>
					var RecaptchaOptions={theme:'clean', custom_translations:" . json_encode(T("mlarray.reCAPTCHA")) . "};
					$('#recaptcha_image').live('click', function() { Recaptcha.reload(); });
				</script>".
				recaptcha_get_html(C('plugin.reCAPTCHA.public'), '', C('esoTalk.https')).
				$form->getError("recaptcha_response_field").
				"<small><i class='icon-question-sign'></i> ".T("message.reCAPTCHARefreshInfo")."</small>";
	}

	function processRecaptchaField($form, $key, &$data)
	{
		// Check for reCaptcha.
		$reCaptcha = true;
		$resp = recaptcha_check_answer (C('plugin.reCAPTCHA.private'), $_SERVER["REMOTE_ADDR"], $form->getValue("recaptcha_challenge_field"), $form->getValue("recaptcha_response_field"));
		$reCaptcha = $resp->is_valid;

		// If no valid words are entered, show them an error.
		if (!$reCaptcha) {
			$form->error("recaptcha_response_field", T("message.invalidCAPTCHA"));
		}
	}

	public function settings($sender)
	{
		// Set up the settings form.
		$form = ETFactory::make("form");
		$form->action = URL("admin/plugins/settings/reCAPTCHA");

		$form->setValue("private", C("plugin.reCAPTCHA.private"));
		$form->setValue("public", C("plugin.reCAPTCHA.public"));

		// If the form was submitted...
		if ($form->validPostBack()) {

			// Construct an array of config options to write.
			$config = array();
			$config["plugin.reCAPTCHA.private"] = $form->getValue("private");
			$config["plugin.reCAPTCHA.public"] = $form->getValue("public");

			// Write the config file.
			ET::writeConfig($config);

			$sender->message(T("message.changesSaved"), "success autoDismiss");
			$sender->redirect(URL("admin/plugins"));
		}

		$sender->data("reCAPTCHASettingsForm", $form);
		return $this->view("settings");
	}
}
