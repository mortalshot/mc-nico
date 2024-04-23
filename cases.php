<?php 
// Template Name: Кейсы
get_header(); 

echo '<main class="page">';
	if (function_exists('kama_breadcrumbs')) :
		kama_breadcrumbs('');
	endif;

	echo '<section class="cases">';
		echo '<div class="cases__container">';
			echo '<div class="cases__heading _heading _content"> <h1>Проведенные нами оценки и экспертизы</h1> </div>';

         $args = array(
            'numberposts' => -1,
            'posts_per_page' => -1,
            'post_type'   => 'services',
            'orderby'     => 'date',
            'order'       => 'DESC',
         );
         
         $query = new WP_Query( $args );

			if ($query->have_posts()) :
				echo '<div class="cases__slider swiper">';
					echo '<div class="cases__wrapper swiper-wrapper">';
						while ($query->have_posts()) :
							$query->the_post();

							$caseGallery = get_field('case_gallery');
							$preview = $caseGallery[0];
							$ID = get_the_ID();
							$taxonomy = wp_get_post_terms(get_the_ID(), 'theme');
							$termID = $taxonomy[0]->term_id;
							$icon = get_field('portfolio-card_icon', 'theme_' . $termID);

							echo '<div class="cases__slide swiper-slide">';
								echo '<div class="portfolio-card">';
									echo '<div class="portfolio-card__bg"><img src="'. $preview['url'] .'" alt="'. $preview['alt'] .'" loading="lazy"></div>';
									echo '<div class="portfolio-card__title">';
										echo '<i class="_icon-'. $icon .'"></i>';
										echo '<span>'. get_the_title() .'</span>';
									echo '</div>';

									echo '<div class="portfolio-card__body">';
										// echo '<div class="portfolio-card__excerpt _content">'. get_the_excerpt() .'</div>';

										echo '<a href="'. get_permalink() .'" class="portfolio-card__link _icon-link"><span>Узнать больше</span></a>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						endwhile;

					echo '</div>';
					echo '<div class="cases__navigation">';
						echo '<div class="swiper__arrow swiper__arrow_left _icon-breadcrumb"></div>';
						echo '<div class="swiper-pagination"></div>';
						echo '<div class="swiper__arrow swiper__arrow_right _icon-breadcrumb"></div>';
					echo '</div>';
				echo '</div>';

				wp_reset_postdata();
			endif;
		echo '</div>';
	echo '</section>';

	include 'blocks.php';
echo '</main>';

get_footer();