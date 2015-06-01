<?php
if (!defined("IN_ESOTALK")) exit;

$form = $data["FaviconForm"];
?>
<?php echo $form->open(); ?>
<div class="section">
	<ul class="form">
		<li>
			<label>Your favicon path</label>
			<?php echo $form->input('path', 'text', array('placeholder' => '/favicon.ico')); ?>
			<small>Enter your full path to your favicon</small>
		<li>
	</ul>
</div>
<div class="buttons">
	<?php echo $form->saveButton("FaviconSave"); ?>
</div>
<?php echo $form->close(); ?>
