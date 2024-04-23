<?php 
// Архивная страница с выводом всех услуг
get_header(); 

echo '<main class="page">';
	if (function_exists('kama_breadcrumbs')) :
		kama_breadcrumbs('');
	endif;

	echo '<section class="services">';
		echo '<div class="services__container">';
			echo '<div class="services__heading _heading _content">';
				echo '<h1>'. get_queried_object()->label .'</h1>';
			echo '</div>';

			$terms = get_terms( [
				'taxonomy' => 'theme',
				'hide_empty' => false,
			]);

			if ($terms) :
				echo '<div class="services__list">';
					foreach ($terms as $item) :
						$taxonomyID = $item->term_taxonomy_id;
						$icon = get_field('portfolio-card_icon', 'theme_' . $taxonomyID);
						$iconBG = get_field('portfolio-card_icon-bg', 'theme_' . $taxonomyID);
						$attributes = get_field('item_attributes', 'theme_' . $taxonomyID);

						echo '<div class="services__item service-item">';
							echo '<div class="service-item__icon" style="background-color: '. $iconBG .';"><i class="_icon-'. $icon .'"></i></div>';
							echo '<div class="service-item__body">';
								echo '<a href="'. get_term_link($taxonomyID) .'" class="service-item__name">'. $item->name .'</a>';
								echo '<div class="service-item__attributes">';
									foreach ($attributes as $attribute) :
										$attributeCaption = $attribute['item_attribute-caption'];
										$attributeValue = $attribute['item_attribute-value'];

										echo '<div class="service-item__attribute">';
											echo '<div class="service-item__attribute-caption">'. $attributeCaption .'</div>';
											echo '<div class="service-item__attribute-value">'. $attributeValue .'</div>';
										echo '</div>';
									endforeach;
								echo '</div>';
		
								echo '<a href="'. get_term_link($taxonomyID) .'" class="service-item__link btn btn_link">';
									echo '<i class="_icon-link"></i>';
									echo '<span>Подробнее</span>';
								echo '</a>';
							echo '</div>';
						echo '</div>';
					endforeach;
				echo '</div>';
			endif;
		echo '</div>';
	echo '</section>';
echo '</main>';

get_footer();