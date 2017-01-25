---
layout: 'php-page'
title: 'contacteer ons'
inMenu: true
menuIcon: 'envelope'
menuOrder: 40
insertHead: '<script src="https://www.google.com/recaptcha/api.js"></script>'
---

	<?php 
		define( 'CONTACT', true );
		require( 'backend/contact/static.php' );
		form_message();
	?>

U kan ons via onderstaande gegevens bereiken, of het contactformulier op deze pagina invullen.
Wij proberen uw aanvragen zo snel mogelijk te beantwoorden.

## Contactgegevens

<div class="contact">
	<div class="contact-item">
		<span class="fa fa-fw fa-building" aria-label="Organisatie: "></span>
		Subterra vzw
	</div>
	<div class="contact-item">
		<span class="fa fa-fw fa-map-marker" aria-label="Adres: "></span>
		<span class="address-line">Cuvelierstraat 13 A</span>
		<span class="address-line">B-3740 Bilzen-Rijkhoven</span>
		<span class="address-line">België</span>
	</div>
	<div class="contact-item">
		<span class="fa fa-fw fa-mobile" aria-label="Gsm: "></span>
		0032 (0)478 56 86 84
	</div>
	<div class="contact-item">
		<span class="fa fa-fw fa-phone" aria-label="Telefoon: "></span>
		0845 410 131
	</div>
</div>



## Contactformulier

<form id="cf" class="<?php form_class(); ?>" action="" method="post">
	<div class="form-row<?php field_class('name'); ?>">
		<div class="label-col">
			<label for="cf-name">
				Naam:
			</label>
		</div>
		<div class="input-col">
			<input type="text" name="contact[name]" id="cf-name" placeholder="Naam *" value="<?php field_value( 'name' ); ?>">
			<?php display_error( 'name' ); ?>
		</div>
	</div>
	<div class="form-row<?php field_class('email'); ?>">
		<div class="label-col">
			<label for="cf-email">
				E-Mail:
			</label>
		</div>
		<div class="input-col">
			<input type="text" name="contact[email]" id="cf-email" placeholder="E-Mail *" value="<?php field_value( 'email' ); ?>">
			<?php display_error( 'email' ); ?>
		</div>
	</div>
	<div class="form-row<?php field_class('phone'); ?>">
		<div class="label-col">
			<label for="cf-phone">
				Telefoonnummer:
			</label>
		</div>
		<div class="input-col">
			<input type="text" name="contact[phone]" id="cf-phone" placeholder="Telefoonnummer" value="<?php field_value( 'phone' ); ?>">
			<?php display_error( 'phone' ); ?>
		</div>
	</div>
	<div class="form-row<?php field_class('message'); ?>">
		<div class="label-col">
			<label for="cf-message">
				Bericht:
			</label>
		</div>
		<div class="input-col">
			<textarea name="contact[message]" id="cf-message" placeholder="Uw bericht *"><?php field_value( 'message' ); ?></textarea>
			<?php display_error( 'message' ); ?>
		</div>
	</div>
	<div class="form-row<?php field_class('captcha'); ?>">
		<div class="captcha-col">
			<div class="g-recaptcha" data-sitekey="6LcgMBIUAAAAABTC3lszbv3Patnrh9arkXTvL-Jl"></div>
			<?php display_error( 'captcha' ); ?>
		</div>
	</div>
	<div class="form-row">
		<div class="notice">
			Velden met een asterisk (*) en de captcha zijn verplicht.
		</div>
	</div>
	<div class="form-row">
		<div class="button-col">
			<button type="submit" name="contact[submit]" id="cf-submit">Verzend</button>
		</div>
	</div>
</form>