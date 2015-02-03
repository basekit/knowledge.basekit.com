## esoTalk – reCAPTCHA plugin

- Protect your forum from spam and abuse while letting real people pass through with ease.

### Release Note

- esoTalk version 1.0.0g4 and beyond is required!

### Installation

Browse to your esoTalk plugin directory:
```
cd WEB_ROOT_DIR/addons/plugins/
```

Clone the reCAPTCHA plugin repo into the plugin directory:
```
git clone git@github.com:tristanvanbokkem/reCAPTCHA.git reCAPTCHA
```

Chown the reCAPTCHA plugin folder to the right web user:
```
chown -R apache:apache reCAPTCHA/
```

### Translation

Create `definitions.reCAPTCHA.php` in your language pack with the following definitions:

```
$definitions["Are you human?"] = "Are you human?";
$definitions["Private Key"] = "Private Key";
$definitions["Public Key"] = "Public Key";
$definitions["message.reCAPTCHARefreshInfo"] = "Click or tap on an image to refresh it.";
$definitions["message.invalidCAPTCHA"] = "The CAPTCHA you entered is invalid. Please try again.";
$definitions["message.reCAPTCHA.settings"] = "Enter your reCAPTCHA Keys (<a href='https://www.google.com/recaptcha/admin#whyrecaptcha' target='_blank'>Got no Keys yet? Get them here!</a>)";
$definitions["mlarray.reCAPTCHA"] = array(
	"instructions_visual" => "Type the two words"
);
```

### Screenshots
Sign Up page
![Sign Up page](http://i.imgur.com/xq3WbLf.png)

Wrong CAPTCHA
![Wrong CAPTCHA](http://i.imgur.com/THqvAsK.png)

reCAPTCHA Settings
![reCAPTCHA Settings](http://i.imgur.com/M7ZX1R1.png)
