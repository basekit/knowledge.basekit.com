<?php
// Copyright 2014 Tristan van Bokkem

if (!defined("IN_ESOTALK")) exit;

$form = $data["reCAPTCHASettingsForm"];
?>
<?php echo $form->open(); ?>

<div class='section'>

<ul class='form'>

<li>
    <label><strong><?php echo T("Private Key"); ?></strong></label>
    <?php echo $form->input("private"); ?>
</li>

<li>
    <label><?php echo T("Public Key"); ?></label>
    <?php echo $form->input("public"); ?>
    <small><?php echo T("message.reCAPTCHA.settings"); ?></small>
</li>


</ul>

</div>

<div class='buttons'>
<?php echo $form->saveButton(); ?>
</div>

<?php echo $form->close(); ?>
