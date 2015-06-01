<?php
// Copyright 2011 Toby Zerner, Simon Zerner
// This file is part of esoTalk. Please see the included license file for usage information.

// Edited by David Darnes - BaseKit Team

if (!defined("IN_ESOTALK")) exit;

/**
 * Default skin file.
 *
 * @package esoTalk
 */

ET::$skinInfo["BaseKitForum"] = array(
	"name" => "BaseKit Forum",
	"description" => "BaseKit Forum, based on the default esoTalk skin.",
	"version" => ESOTALK_VERSION,
	"author" => "BaseKit Team",
	"authorEmail" => "team@basekit.com",
	"authorURL" => "http://developers.basekit.com",
	"license" => "MIT"
);

class ETSkin_BaseKitForum extends ETSkin {


/**
 * Initialize the skin.
 *
 * @param ETController $sender The page controller.
 * @return void
 */
public function handler_init($sender)
{
	$sender->addCSSFile((C("esoTalk.https") ? "https" : "http")."://fonts.googleapis.com/css?family=Open+Sans:400,600");
	$sender->addCSSFile("core/skin/base.css", true);
	$sender->addCSSFile("core/skin/font-awesome.css", true);
	$sender->addCSSFile($this->resource("styles.css"), true);

	$sender->addToMenu("user", "Links", "<a href='http://developers.basekit.com'>Developers Hub</a>");

	// If we're viewing from a mobile browser, add the mobile CSS and change the master view.
	if ($isMobile = isMobileBrowser()) {
		$sender->addCSSFile($this->resource("mobile.css"), true);
		$sender->masterView = "mobile.master";
		$sender->addToHead("<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0'>");
	}

	$sender->addCSSFile("config/colors.css", true);

	if (!C("skin.BaseKitForum.primaryColor")) $this->writeColors("#364159");

	$sender->addToHead("
		<!-- Favicons -->
		<link rel='shortcut icon' href='".getWebPath($this->resource("favicons/favicon.ico"))."'>
		<link rel='apple-touch-icon' sizes='57x57' href='".getWebPath($this->resource("favicons/apple-touch-icon-57x57.png"))."'>
		<link rel='apple-touch-icon' sizes='114x114' href='".getWebPath($this->resource("favicons/apple-touch-icon-114x114.png"))."'>
		<link rel='apple-touch-icon' sizes='72x72' href='".getWebPath($this->resource("favicons/apple-touch-icon-72x72.png"))."'>
		<link rel='apple-touch-icon' sizes='144x144' href='".getWebPath($this->resource("favicons/apple-touch-icon-144x144.png"))."'>
		<link rel='apple-touch-icon' sizes='60x60' href='".getWebPath($this->resource("favicons/apple-touch-icon-60x60.png"))."'>
		<link rel='apple-touch-icon' sizes='120x120' href='".getWebPath($this->resource("favicons/apple-touch-icon-120x120.png"))."'>
		<link rel='apple-touch-icon' sizes='76x76' href='".getWebPath($this->resource("favicons/apple-touch-icon-76x76.png"))."'>
		<link rel='apple-touch-icon' sizes='152x152' href='".getWebPath($this->resource("favicons/apple-touch-icon-152x152.png"))."'>
		<link rel='apple-touch-icon' sizes='180x180' href='".getWebPath($this->resource("favicons/apple-touch-icon-180x180.png"))."'>
		<link rel='icon' type='image/png' href='".getWebPath($this->resource("favicons/favicon-192x192.png"))."' sizes='192x192'>
		<link rel='icon' type='image/png' href='".getWebPath($this->resource("favicons/favicon-160x160.png"))."' sizes='160x160'>
		<link rel='icon' type='image/png' href='".getWebPath($this->resource("favicons/favicon-96x96.png"))."' sizes='96x96'>
		<link rel='icon' type='image/png' href='".getWebPath($this->resource("favicons/favicon-16x16.png"))."' sizes='16x16'>
		<link rel='icon' type='image/png' href='".getWebPath($this->resource("favicons/favicon-32x32.png"))."' sizes='32x32'>
		<meta name='msapplication-TileColor' content='#ffffff'>
		<meta name='msapplication-TileImage' content='".getWebPath($this->resource("/favicons/mstile-144x144.png"))."'>
	");
}


/**
 * Write the skin's color configuration and CSS.
 *
 * @param string $primary The primary color.
 * @return void
 */
protected function writeColors($primary)
{
	ET::writeConfig(array("skin.BaseKitForum.primaryColor" => $primary));

	$rgb = colorUnpack($primary, true);
	$hsl = rgb2hsl($rgb);

	$primary = colorPack(hsl2rgb($hsl), true);

	$hsl[1] = max(0, $hsl[1] - 0.3);
	$secondary = colorPack(hsl2rgb(array(2 => 0.6) + $hsl), true);
	$tertiary = colorPack(hsl2rgb(array(2 => 0.92) + $hsl), true);

	$css = file_get_contents($this->resource("colors.css"));
	$css = str_replace(array("{primary}", "{secondary}", "{tertiary}"), array($primary, $secondary, $tertiary), $css);
	file_put_contents(PATH_CONFIG."/colors.css", $css);
}


/**
 * Construct and process the settings form for this skin, and return the path to the view that should be
 * rendered.
 *
 * @param ETController $sender The page controller.
 * @return string The path to the settings view to render.
 */
public function settings($sender)
{
	// Set up the settings form.
	$form = ETFactory::make("form");
	$form->action = URL("admin/appearance");
	$form->setValue("primaryColor", C("skin.BaseKitForum.primaryColor"));

	// If the form was submitted...
	if ($form->validPostBack("save")) {
		$this->writeColors($form->getValue("primaryColor"));

		$sender->message(T("message.changesSaved"), "success autoDismiss");
		$sender->redirect(URL("admin/appearance"));
	}

	$sender->data("skinSettingsForm", $form);
	$sender->addJSFile("core/js/lib/farbtastic.js");
	return $this->view("settings");
}


}
