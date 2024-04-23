<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php 
	wp_body_open();
	
	echo '<div class="wrapper">';
		echo '<header class="header">';
			echo '<div class="header__container">';
				echo '<div class="header__left">';
					$headerLogo = get_field('header-logo', 'options');
					echo '<div class="header__logo"><a href="'. get_home_url() .'"><img src="'. $headerLogo['url'] .'" alt="'. $headerLogo['alt'] .'" loading="lazy"></a></div>';
					echo '<div class="header__menu menu">';
						echo '<button type="button" class="menu__icon icon-menu"><span></span></button>';
						
						echo '<nav class="menu__body">';
							wp_nav_menu( [
								'theme_location'  => 'header',
								'container'       => false,
								'menu_class'      => 'menu__list',
								'after'           => '<button type="button" class="menu__arrow _icon-select" tabindex="-1"></button>',
								'walker'          => new My_Walker_Nav_Menu()
							] );
						echo '</nav>';
					echo '</div>';
				echo '</div>';

				$contacts = get_field('contacts', 'options');
				echo '<div class="header__right">';
					echo '<div class="header__contacts">';
						echo '<div class="contacts">';
							$phones = $contacts['phones'];
							if ($phones) :
								echo '<div class="contacts__group _icon-phone-call">';
									$j = 0;
									foreach ($phones as $item) :
										$phone = $item['phone'];
										$phonePreg =  preg_replace("/[^0-9]/", '', $phone);
	
										if ($j < 2) :
											echo '<div class="contacts__item _nowrap"><a href="tel:+'. $phonePreg .'">'. $phone .'</a></div>';
										endif;
	
										$j ++;
									endforeach;
								echo '</div>';
							endif;

							$emails = $contacts['emails'];
							if ($emails) :
								echo '<div class="contacts__group _icon-mail">';
									$j = 0;
									foreach ($emails as $item) :
										$email = $item['email'];
	
										if ($j == 0) :
											echo '<div class="contacts__item"><a href="mailto:'. $email .'">'. $email .'</a></div>';
										endif;
	
										$j ++;
									endforeach;
								echo '</div>';
							endif;
						echo '</div>';

						$messengers = $contacts['messengers'];
						$telegram = $messengers['telegram'];
						$whatsapp = $messengers['whatsapp'];
						$viber = $messengers['viber'];
						if ($telegram || $whatsapp || $viber) :
							echo '<div class="socials">';
								echo $telegram != '' ? '<div class="socials__item"><a href="'. $telegram .'" class="_icon-telegram"></a></div>' : '';
								echo $whatsapp != '' ? '<div class="socials__item"><a href="'. $whatsapp .'" class="_icon-whatsapp"></a></div>' : '';
								echo $viber != '' ? '<div class="socials__item"><a href="'. $viber .'" class="_icon-viber"></a></div>' : '';
							echo '</div>';
						endif;
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</header>';

		$headerImage = get_field('header-image', 'options');
		echo '<div class="header-image"><img src="'. $headerImage['url'] .'" alt="'. $headerImage['alt'] .'"></div>';
	?>