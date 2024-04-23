<?php 
get_header(); 

echo '<main class="page">';
	if (!is_home()) :
		kama_breadcrumbs('');
	endif;
	
	echo '<section class="blog">';
      echo '<div class="blog__container">';
         echo '<div class="blog__heading _heading _content"> <h1>Блог</h1> </div>';
         
         if (have_posts()) :
            echo '<div class="blog__list">';
               while (have_posts()) :
                  the_post();

                  echo '<article class="blog__item news-card">';
                     echo '<a href="'. get_permalink() .'" class="news-card__title">'. get_the_title() .'</a>';
                     echo '<div class="news-card__excerpt _content">'. get_the_excerpt() .'</div>';
                     echo '<a href="'. get_permalink() .'" class="news-card__link">';
                        echo '<i class="_icon-link"></i>';
                        echo '<span>Читать далее</span>';
                     echo '</a>';
                  echo '</article>';
               endwhile;
            echo '</div>';

            echo '<div class="blog__navigation navigation">';
               the_posts_pagination(array(
                  'mid_size' => 3,
                  'prev_next'    => true,
                  'prev_text'    => __('<i class="_icon-breadcrumb"></i>'),
                  'next_text'    => __('<i class="_icon-breadcrumb"></i>'),
               ));
            echo '</div>';

            wp_reset_postdata();
         endif;
      echo '</div>';
   echo '</section>';
echo '</main>';

get_footer();