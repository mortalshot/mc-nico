<?php 
			echo '<footer class="footer">';
				echo '<div class="footer__container">';
					echo '<div class="footer__top">';
						echo '<div class="footer__company">';
							$footerLogo = get_field('footer-logo', 'options');
							echo '<a href="'. get_home_url() .'" class="footer__logo"><img src="'. $footerLogo['url'] .'" alt="'. $footerLogo['alt'] .'"></a>';
							echo '<div class="footer__text">'. get_bloginfo('description') .'</div>';
						echo '</div>';

						$contacts = get_field('contacts', 'options');
						echo '<div class="footer__contacts">';
							echo '<div class="contacts">';
								$phones = $contacts['phones'];
								if ($phones) :
									echo '<div class="contacts__group _icon-phone-call">';
										foreach ($phones as $item) :
											$phone = $item['phone'];
											$phonePreg =  preg_replace("/[^0-9]/", '', $phone);

											echo '<div class="contacts__item _nowrap"><a href="tel:+'. $phonePreg .'">'. $phone .'</a></div>';
										endforeach;
									echo '</div>';
								endif;

								$emails = $contacts['emails'];
								if ($emails) :
									echo '<div class="contacts__group _icon-mail">';
										foreach ($emails as $item) :
											$email = $item['email'];

											echo '<div class="contacts__item"><a href="mailto:'. $email .'">'. $email .'</a></div>';
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

						echo '<div class="footer__menu menu">';
							echo '<nav class="menu__body">';
								wp_nav_menu( [
									'theme_location'  => 'footer',
									'container'       => false,
									'menu_class'      => 'menu__list',
								] );
							echo '</nav>';
						echo '</div>';
					echo '</div>';
					echo '<div class="footer__bottom">';
						echo '<div class="footer__copyright">Ⓒ '. date("Y") .' Все права защищены</div>';
						echo '<a href="'. get_privacy_policy_url() .'" class="footer__privacy">Юридическая информация</a>';
					echo '</div>';
				echo '</div>';
			echo '</footer>';
		echo '</div>';
		wp_footer();
	echo '</body>';
echo '</html>';
