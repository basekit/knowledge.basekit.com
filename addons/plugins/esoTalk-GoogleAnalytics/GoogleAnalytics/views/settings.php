<?php
// Copyright 2013 ciruz
if (!defined("IN_ESOTALK")) exit;

$form = $data["GoogleAnalyticsForm"];
?>
<?php echo $form->open(); ?>
<div class="section">
	<ul class="form">
		<li>
			<label>Your Property-ID</label>
			<?php echo $form->input('propertyId', 'text', array('placeholder' => 'UA-000000-00')); ?>
			<small>Enter your Google Analytics Property-ID (<a href="https://support.google.com/analytics/answer/1032385" target="_blank">A what? Help me</a>)</small>
		<li>
	</ul>
</div>
<div class="buttons">
	<?php echo $form->saveButton("GoogleAnalyticsSave"); ?>
</div>
<?php echo $form->close(); ?>