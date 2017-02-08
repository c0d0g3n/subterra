<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<meta name="HandheldFriendly" content="True" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<!-- chrome theme, match inverted background color -->
	<meta name="theme-color" content="#1a1a1a">
	<!-- <link rel="icon" sizes="192x192" href="nice-highres.png"> -->
	<link rel="canonical" href="http://192.168.0.14/subterra/contact" />

	<title>contacteer ons - Subterra</title>

	<meta name="generator" content="DocPad v6.79.0" />
	<link  rel="stylesheet" href="http://192.168.0.14/subterra/assets/css/normalize.css" /><link  rel="stylesheet" href="http://192.168.0.14/subterra/assets/css/font-awesome.css" /><link  rel="stylesheet" href="http://192.168.0.14/subterra/assets/css/screen.css" />

	<script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body class="">

	<div id="page">
		<div id="page-background">
			<div id="page-overlay"></div>
		</div>
		<div id="above-fold">
			<div id="header-row">
				<header id="page-header">
					<div id="page-header-title">
						<a href="http://192.168.0.14/subterra" title="Homepage"><h1>Subterra</h1></a>
					</div>
					<!-- <p class="tag-line">Awesome recording studio</p> -->
					<div id="page-nav-toggle">
						<a href="#toggle" title="toggle navigation">
							<span class="fa fa-bars"></span>
						</a>
					</div>
				</header>
			</div>
		</div>
		<div id="under-fold">
			<div id="main-row">
				<nav id="page-nav">
					<ul>
						<li class="nav-item">
							<a href="http://192.168.0.14/subterra/index.html" title="Homepage">
								<span class="text">Homepage</span>
								<span class="fa fa-home" aria-hidden="true"></span>
							</a>
						</li><li class="nav-item">
							<a href="http://192.168.0.14/subterra/apperatuur.html" title="Apperatuur">
								<span class="text">Apperatuur</span>
								<span class="fa fa-wrench" aria-hidden="true"></span>
							</a>
						</li><li class="nav-item">
							<a href="http://192.168.0.14/subterra/werkwijze_en_prijslijst.html" title="Werkwijze en prijzen">
								<span class="text">Werkwijze en prijzen</span>
								<span class="fa fa-handshake-o" aria-hidden="true"></span>
							</a>
						</li><li class="nav-item active">
							<a href="http://192.168.0.14/subterra/contact.php" title="contacteer ons">
								<span class="text">contacteer ons</span>
								<span class="fa fa-envelope" aria-hidden="true"></span>
							</a>
						</li>
						<!-- <li>
							<a href="#test" title="test">
								T
							</a>
						</li>
						<li>
							<a href="#test" title="test">
								T
							</a>
						</li>
						<li>
							<a href="#test" title="test">
								T
							</a>
						</li>
						<li>
							<a href="#test" title="test">
								T
							</a>
						</li>
						<li>
							<a href="#test" title="test">
								T
							</a>
						</li> -->
						<!-- <li><a href="#">test</a></li>
						<li><a href="#">test</a></li>
						<li><a href="#">test</a></li>
						<li><a href="#">test</a></li>
						<li><a href="#">test</a></li>
						<li><a href="#">test</a></li>
						<li><a href="#">test</a></li>
						<li><a href="#">test</a></li> -->
					</ul>
				</nav>
				<main id="page-content">
					<article id="article-contacteer-ons">
						<header class="content-header">
							<h1>contacteer ons</h1>
						</header>
						<?php 
		define( 'CONTACT', true );
		require( 'backend/contact/static.php' );
		form_message();
	?>
<p>U kan ons via onderstaande gegevens bereiken, of het contactformulier op deze pagina invullen.
Wij proberen uw aanvragen zo snel mogelijk te beantwoorden.</p>
<h2 id="contactgegevens">Contactgegevens</h2>
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



<h2 id="contactformulier">Contactformulier</h2>
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
					</article>
				</main>
			</div>
			<footer id="page-footer">
				<a id="scroll-to-top" href="#above-fold" title="Scroll back to top"><span class="fa fa-chevron-up" aria-hidden="true"></span></a>
				<p class="copyright">
					Copyright info
				</p><p class="theme">
					Stellar Theme by C0d0g3n
				</p>
			</footer>
		</div>
	</div>

	<script defer="defer"  src="http://192.168.0.14/subterra/assets/js/jquery-3.1.1.js"></script><script defer="defer"  src="http://192.168.0.14/subterra/assets/js/main.js"></script>
</body>
</html>