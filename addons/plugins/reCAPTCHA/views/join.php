<?php
// Copyright 2014 Tristan van Bokkem

if (!defined("IN_ESOTALK")) exit;

/**
 * Displays the 'sign up' sheet
 * with reCAPTCHA check.
 */

$form = $data["form"];
?>
<div id='joinSheet' class='sheet'>
<div class='sheetContent'>

<h3><?php echo T("Sign Up"); ?></h3>

<?php echo $form->open(); ?>

<div class='sheetBody'>

<div class='section'>
<ul class='form'>

<li><label><?php echo T("Username"); ?></label> <?php echo $form->input("username"); ?></li>

<li><label><?php echo T("Email"); ?></label> <?php echo $form->input("email"); ?><small><?php echo T("Used to verify your account and subscribe to conversations"); ?></small></li>

<li><label><?php echo T("Password"); ?></label> <?php echo $form->input("password", "password"); ?><small><?php printf(T("Choose a secure password of at least %s characters"), C("esoTalk.minPasswordLength")); ?></small></li>

<li><label><?php echo T("Confirm password"); ?></label> <?php echo $form->input("confirm", "password"); ?></li>

<?php if(C('plugin.reCAPTCHA.private') && C('plugin.reCAPTCHA.public')): ?>
    <li>
        <label><?php echo T("Are you human?"); ?></label>
        <?php foreach ($form->getSections() as $section => $title): ?>
            <?php foreach ($form->getFieldsInSection($section) as $field): ?>
                <?php echo $field; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <?php echo $form->addHidden("recaptcha_response_field", "manual_challenge"); ?>
        <?php echo $form->getError("recaptcha_response_field"); ?>
        <small><i class="icon-question-sign"></i> <?php echo T("message.reCAPTCHARefreshInfo"); ?></small>
    </li>
<?php endif; ?>

</ul>
</div>

</div>

<div class='buttons'>
<small><?php printf(T("Already have an account? <a href='%s' class='link-login'>Log in!</a>"), URL("user/login")); ?></small>
<?php
echo $form->button("submit", T("Sign Up"), array("class" => "big submit"));
echo $form->cancelButton();
?>
</div>

<?php echo $form->close(); ?>

</div>
</div>
