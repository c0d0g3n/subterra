---
layout: 'php-page'
title: 'contactformulier'
inMenu: true
menuIcon: 'envelope'
menuOrder: 30
---

	<?php 
		define( 'CONTACT', true );
		require( 'backend/contact/static.php' );
		form_message();
	?>

U kan het onderstaande formulier gebruiken om meer info te vragen of de studio te reserveren.
Wij sturen dan zo snel mogelijk een bericht terug.

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
	<div class="form-row">
		<div class="notice">
			Velden met een asterisk (*) zijn verplicht.
		</div>
	</div>
	<div class="form-row">
		<div class="button-col">
			<button type="contact[submit]" name="submit" id="cf-submit">Verzend</button>
		</div>
	</div>
</form>