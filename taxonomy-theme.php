<?php 
// Одиночная страница с описанием услуги
get_header(); 

echo '<main class="page">';
	if (function_exists('kama_breadcrumbs')) :
		kama_breadcrumbs('');
	endif;
	
	$taxonomyID = get_queried_object()->term_id;
	$icon = get_field('portfolio-card_icon', 'theme_' . $taxonomyID);
	$attributes = get_field('item_attributes', 'theme_' . $taxonomyID);
	$mainImage = get_field('main_image', 'theme_' . $taxonomyID);

	echo '<section class="service-main">';
		echo '<div class="service-main__wrapper">';
			echo '<div class="service-main__container">';
				echo '<div class="service-main__row">';
					echo '<div class="service-main__body">';
						echo '<h1 class="service-main__title">'. get_queried_object()->name .'</h1>';

						echo '<div class="service-main__attributes">';
							foreach ($attributes as $attribute) :
								$attributeCaption = $attribute['item_attribute-caption'];
								$attributeValue = $attribute['item_attribute-value'];

								echo '<div class="service-main__attribute">';
									echo '<div class="service-main__attribute-caption">'. $attributeCaption .'</div>';
									echo '<div class="service-main__attribute-value">'. $attributeValue .'</div>';
								echo '</div>';
							endforeach;
						echo '</div>';

						echo '<div class="service-main__form form">';
							echo do_shortcode('[contact-form-7 id="251" title="Форма таксономии"]');
						echo '</div>';
					echo '</div>';
					echo '<div class="service-main__image"><img src="'. $mainImage['url'] .'" alt="'. $mainImage['alt'] .'"></div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</section>';

	include 'blocks.php';

	echo '<section id="order" class="order">';
		echo '<div class="order__container">';
			echo '<div class="order__wrapper">';
				$text = get_field('order_text', 'options');
				echo $text != '' ? '<div class="order__text _content">' . $text . '</div>' : '';

				echo '<div class="order__form">';
					echo do_shortcode('[contact-form-7 id="157" title="Запрос примера экспертизы"]');
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</section>';
echo '</main>';

get_footer();