---
layout: 'page'
title: 'contactformulier'
inMenu: true
menuIcon: 'envelope'
---

Gebruik het onderstaande formulier

U kan het onderstaande formulier gebruiken om meer info te vragen of de studio te reserveren.
Wij sturen dan zo snel mogelijk een bericht terug.

<form id="cf">
	<div class="form-row">
		<div class="label-col">
			<label for="cf-name">
				Naam:
			</label>
		</div>
		<div class="input-col">
			<input type="text" name="name" id="cf-name" placeholder="Naam">
		</div>
	</div>
	<div class="form-row">
		<div class="label-col">
			<label for="cf-email">
				E-Mail:
			</label>
		</div>
		<div class="input-col">
			<input type="text" name="email" id="cf-email" placeholder="E-Mail">
		</div>
	</div>
	<div class="form-row">
		<div class="label-col">
			<label for="cf-phone">
				Telefoonnummer:
			</label>
		</div>
		<div class="input-col">
			<input type="text" name="phone" id="cf-phone" placeholder="Telefoonnummer">
		</div>
	</div>
	<div class="form-row">
		<div class="label-col">
			<label for="cf-message">
				Bericht:
			</label>
		</div>
		<div class="input-col">
			<input type="text" name="message" id="cf-message" placeholder="Bericht">
			<textarea name="message" id="cf-message" placeholder="Uw bericht"></textarea>
		</div>
	</div>
	<div class="form-row">
		<div class="button-col">
			<button type="submit" name="submit" id="cf-submit">Verzend</button>
		</div>
	</div>
</form>