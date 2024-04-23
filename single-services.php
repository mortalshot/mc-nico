<?php 
// Одиночная страница услуги
get_header(); 

echo '<main class="page">';
	if (function_exists('kama_breadcrumbs')) :
		kama_breadcrumbs('');
	endif;

	echo '<section class="case">';
		echo '<div class="case__container">';
			echo '<div class="case__heading _heading _content"> <h1>'. get_the_title() .'</h1> </div>';

			echo '<div class="case__row">';
				$caseGallery = get_field('case_gallery');
				echo '<div class="case__gallery" data-gallery>';
					foreach ($caseGallery as $image) :
						echo '<div class="case__image" data-src="'. $image['url'] .'"><img src="'. $image['url'] .'" alt="'. $image['alt'] .'"></div>';
					endforeach;
				echo '</div>';

				echo '<div class="case__body">';
					echo '<div class="_content">'. get_field('case_body') .'</div>';

					echo '<ul class="case__navigation single-navigation" data-da=".case__container, 992, last">';
						// $prevPost = get_adjacent_post(true, '', true, 'theme');
						$prevPost = get_previous_post();

						if ($prevPost) :
							$prevPostID = $prevPost->ID;
						else:
							$taxonomy = wp_get_post_terms(get_the_ID(), 'theme');
							$query = new WP_Query( [
								'post_type' => 'services',
								'order'     => 'ASC',
								// 'tax_query' => array(
								// 	array(
								// 		'taxonomy' => 'theme',
								// 		'field'    => 'name',
								// 		'terms'    => $taxonomy[0]->name
								// 	)
								// )
							] );
		
							while ($query -> have_posts()) :
								$query -> the_post();
								$prevPostID = get_the_ID();
							endwhile;
		
							wp_reset_postdata();
						endif;

						echo '<a href="'. get_permalink($prevPostID) .'" class="single-navigation__link single-navigation__link_prev">';
							echo '<i class="_icon-link2"></i>';
							echo '<span>'. get_the_title($prevPostID) .'</span>';
						echo '</a>';

						// $nextPost = get_adjacent_post( true, '', false, 'theme' );
						$nextPost = get_next_post();
						if ($nextPost) :
							$nextPostID = $nextPost->ID;
						else:
							$taxonomy = wp_get_post_terms(get_the_ID(), 'theme');

							$query = new WP_Query( [
								'post_type' => 'services',
								'order'     => 'ASC',
								// 'tax_query' => array(
								// 	array(
								// 		'taxonomy' => 'theme',
								// 		'field'    => 'name',
								// 		'terms'    => $taxonomy[0]->name
								// 	)
								// )
							] );

							$j = 0;
							while ($query -> have_posts()) :
								$query -> the_post();
								if ($j == 0) {
									$nextPostID = get_the_ID();
									break;
								}
								$j++;
							endwhile;

							wp_reset_postdata();
						endif;

						echo '<a href="'. get_permalink($nextPostID) .'" class="single-navigation__link single-navigation__link_next">';
							echo '<i class="_icon-link2"></i>';
							echo '<span>'. get_the_title($nextPostID) .'</span>';
						echo '</a>';
					echo '</ul>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</section>';

	echo '<section class="order order_second">';
		echo '<div class="order__container">';
			echo '<div class="order__wrapper">';
				echo '<div class="order__text _content">'. get_field('order_text', 'options') .'</div>';

				echo '<div class="order__form">';
					echo do_shortcode('[contact-form-7 id="157" title="Запрос примера экспертизы"]');
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</section>';
echo '</main>';

get_footer();