<?php
$blocks = get_field('all_blocks');
$blocks == '' ? $blocks = get_field('all_blocks', 'theme_' . get_queried_object()->term_id) : '';

if ($blocks) :
   $i = 1;

   foreach ($blocks as $block) :
      if ($block['acf_fc_layout'] == 'template1') :
         $bg = $block['template1_bg'];
         $companyLogo = $block['template1_company-logo'];
         $text = $block['template1_text'];

         echo '<section id="template1-' . $i . '" class="template1">';
            echo '<div class="template1__bg"><img src="' . $bg['url'] . '" alt="' . $bg['alt'] . '" loading="lazy"></div>';

            echo '<div class="template1__top">';
               echo '<div class="template1__container">';
                  echo '<div class="template1__body">';
                     echo '<div class="template1__company">';
                        echo '<div class="template1__company-logo"><img src="'. $companyLogo['url'] .'" alt="'. $companyLogo['alt'] .'"></div>';
                        echo '<div class="template1__company-text">'. get_bloginfo('description') .'</div>';
                     echo '</div>';

                     echo $text != '' ? '<div class="template1__text _content">' . $text . '</div>' : '';

                     echo '<div class="template1__form form">';
								echo do_shortcode('[contact-form-7 id="9" title="Форма в секции Главная"]');
							echo '</div>';
                  echo '</div>';
               echo '</div>';
            echo '</div>';

            $terms = get_terms( [
               'taxonomy' => 'theme',
               'hide_empty' => false,
            ] );

            if ($terms) :
               echo '<div class="template1__services template1-services">';
                  echo '<div class="template1-services__container">';
                     echo '<div class="template1-services__heading _content">'. $block['template1-services_heading'] .'</div>';

                     echo '<div class="template1-services__list">';
                        foreach ($terms as $item) :
                           $taxonomyID = $item->term_taxonomy_id;
                           $icon = get_field('portfolio-card_icon', 'theme_' . $taxonomyID);

                           echo '<a href="'. get_term_link($taxonomyID) .'" class="template1-services__item">';
                              echo '<i class="_icon-'. $icon .'"></i>';
                              echo '<span>'. $item->name .'</span>';
                           echo '</a>';
                        endforeach;
                        echo '</div>';
                  echo '</div>';
               echo '</div>';
            endif;

         echo '</section>';
      elseif ($block['acf_fc_layout'] == 'template2') :
         $heading = $block['lawyers-header'];
         $featuresLawyers = $block['features-lawyers'];
         $lawyersText = $block['lawyers-text'];
         $lawyersIndicators = $block['lawyers-indicators'];
         $headlineExperts = $block['headline-experts'];
         $lawyersExperts = $block['lawyers-experts'];

         echo '<section id="lawyers-' . $i . '" class="lawyers">';
            echo '<div class="lawyers__container">';
               echo $heading != '' ? '<div class="lawyers__heading _content">' . $heading . '</div>' : '';
               
               if ($featuresLawyers) :
                  echo '<div class="lawyers__features features-lawyers">';
                     foreach ($featuresLawyers as $item) :
                        $itemIcon = $item['features-lawyers_icon'];
                        $itemCaption = $item['features-lawyers_caption'];


                        echo '<div class="features-lawyers__item">';
                           echo '<div class="features-lawyers__icon"><img src="'. $itemIcon['url'] .'" alt="'. $itemIcon['alt'] .'" loading="lazy"></div>';
                           echo '<div class="features-lawyers__caption">'. $itemCaption .'</div>';
                        echo '</div>';
                     endforeach;
                  echo '</div>';
               endif;

               echo $lawyersText != '' ? '<div class="lawyers__text _content">' . $lawyersText . '</div>' : '';

               if ($lawyersIndicators) :
                  echo '<div class="lawyers__indicators lawyers-indicators">';
                     foreach ($lawyersIndicators as $item) :
                        $itemBg = $item['lawyers-indicators_bg'];
                        $itemValue = $item['lawyers-indicators_value'];
                        $itemCaption = $item['lawyers-indicators_caption'];


                        echo '<div class="lawyers-indicators__item">';
                           echo '<div class="lawyers-indicators__bg" style="background-color: '. $itemBg .';"></div>';
                           echo '<div class="lawyers-indicators__text">';
                              echo '<div class="lawyers-indicators__value">'. $itemValue .'</div>';
                              echo '<div class="lawyers-indicators__caption">'. $itemCaption .'</div>';
                           echo '</div>';
                        echo '</div>';
                     endforeach;
                  echo '</div>';
               endif;

               echo $headlineExperts != '' ? '<div class="lawyers__heading _content">' . $headlineExperts . '</div>' : '';

               if ($lawyersExperts) :
                  echo '<div class="lawyers__experts lawyers-experts">';
                     foreach ($lawyersExperts as $item) :
                        $itemImage = $item['lawyers-experts_image'];
                        $itemName = $item['lawyers-experts_name'];
                        $itemText = $item['lawyers-experts_text'];

                        echo '<div class="lawyers-experts__item">';
                           if ($itemImage) :
                              echo '<div class="lawyers-experts__image"><img src="'. $itemImage['url'] .'" alt="'. $itemImage['alt'] .'" loading="lazy"></div>';
                           else:
                              echo '<div class="lawyers-experts__image"><img src="'. get_template_directory_uri() .'/dist/img/main/lawyers-experts-6.svg" alt="" loading="lazy"></div>';
                           endif;
                           echo '<div class="lawyers-experts__body">';
                              echo '<div class="lawyers-experts__name">'. $itemName .'</div>';
                              echo $itemText != '' ? '<div class="lawyers-experts__text _content">'. $itemText .'</div>' : '';
                           echo '</div>';
                        echo '</div>';
                     endforeach;
                  echo '</div>';
               endif;
            echo '</div>';

            $algorithm = $block['algorithm'];
            $algorithmHeading = $algorithm['algorithm_heading'];
            $algorithmItems = $algorithm['algorithm_items'];
            $algorithmButton = $algorithm['algorithm_button'];
            $algorithmButtonID = $algorithm['algorithm_button-id'];

            echo '<div class="algorithm">';
					echo '<div class="algorithm__container">';
						echo '<div class="algorithm__wrapper">';
                     echo $algorithmHeading != '' ? '<div class="algorithm__heading _content">' . $algorithmHeading . '</div>' : '';

							echo '<div class="algorithm__items">';
                        $j = 1;
                        foreach ($algorithmItems as $item) :
                           $itemIcon = $item['algorithm_item-icon'];
                           $itemText = $item['algorithm_item-text'];


                           echo '<div class="algorithm__item">';
                              echo '<div class="algorithm__item-icon"><img src="'. $itemIcon['url'] .'" alt="'. $itemIcon['alt'] .'" loading="lazy"></div>';
                              echo '<div class="algorithm__item-caption">'. $itemText .'</div>';
                              echo '<div class="algorithm__item-counter"><span>'. $j .'</span></div>';
                           echo '</div>';

                           $j++;
                        endforeach;
							echo '</div>';

							echo $algorithmButton != '' ? '<div class="algorithm__button"><button class="btn btn_blue" data-goto="'. $algorithmButtonID .'" data-goto-top="120">'. $algorithmButton .'</button></div>' : '';
						echo '</div>';
					echo '</div>';
				echo '</div>';
         echo '</section>';
      elseif ($block['acf_fc_layout'] == 'template3') :
         $select = $block['faq_select'];
         $select == "Шаблон 1" ? $class = 'faq' : $class = 'faq2';

         $heading = $block['faq_heading'];
         $heading != '' ? '' : $heading = get_field('faq_heading', 'options');
         $spollers = $block['faq_spollers'];
         $spollers != '' ? '' : $spollers = get_field('faq_spollers', 'options');

         echo '<section id="faq-' . $i . '" class="'. $class .'">';
            echo '<div class="'. $class .'__container">';
               if ($select == "Шаблон 1") :
                  echo '<div class="'. $class .'__heading heading-bg">';
                     echo '<div class="_content">'. $heading .'</div>';
                     echo '<div class="heading-bg__icon"><img src="'. get_template_directory_uri() .'/dist/img/main/faq-icon.svg" alt=""></div>';
                  echo '</div>';
               else:
                  echo '<div class="'. $class .'__heading _heading _content">'. $heading .'</div>';
               endif;

               if ($spollers) :
                  echo '<div data-spollers class="faq__spollers spollers">';
                     foreach ($spollers as $item) :
                        $question = $item['question'];
                        $answer = $item['answer'];

                        echo '<div class="spollers__item">';
                           echo '<button type="button" data-spoller class="spollers__title">';
                              echo '<span class="spollers__icon"><span class="spollers__icon-inner"></span></span>';
                              echo '<span>'. $question .'</span>';
                           echo '</button>';
                           echo '<div class="spollers__body">';
                              echo '<div class="_content">'. $answer .'</div>';
                           echo '</div>';
                        echo '</div>';
                     endforeach;
                  echo '</div>';
               endif;
            echo '</div>';
         echo '</section>';
      elseif ($block['acf_fc_layout'] == 'template4') :
         $heading = $block['portfolio-widget_heading'];
         $heading != '' ? '' : $heading = get_field('portfolio-widget_heading', 'options');
         $slider = $block['portfolio-widget_slider'];
         $slider != '' ? '' : $slider = get_field('portfolio-widget_slider', 'options');
         $orderText = $block['order_text'];
         $orderText != '' ? '' : $orderText = get_field('order_text', 'options');

         echo '<section id="portfolio-widget-' . $i . '" class="portfolio-widget">';
            echo '<div class="portfolio-widget__container">';
               echo $heading != '' ? '<div class="portfolio-widget__heading _content">' . $heading . '</div>' : '';

               if ($slider) :
                  echo '<div class="portfolio-widget__slider swiper">';
                     echo '<div class="swiper__arrow swiper__arrow_left _icon-slider-arrow"></div>';
                     echo '<div class="portfolio-widget__wrapper swiper-wrapper">';
                        foreach ($slider as $item) :
                           $id = $item['portfolio-card'];
                           $caseGallery = get_field('case_gallery', $id);
                           $preview = $caseGallery[0];
                           $taxonomy = wp_get_post_terms($id, 'theme');
						         $termID = $taxonomy[0]->term_id;
                           $icon = get_field('portfolio-card_icon', 'theme_' . $termID);

                           echo '<div class="portfolio-widget__slide swiper-slide">';
                              echo '<div class="portfolio-card">';
                                 echo '<div class="portfolio-card__bg"><img src="'. $preview['url'] .'" alt="'. $preview['alt'] .'" loading="lazy"></div>';
                                 echo '<div class="portfolio-card__title">';
                                    echo '<i class="_icon-'. $icon .'"></i>';
                                    echo '<span>'. get_the_title($id) .'</span>';
                                 echo '</div>';
      
                                 echo '<div class="portfolio-card__body">';
                                    // echo '<div class="portfolio-card__excerpt _content">'. get_the_excerpt($id) .'</div>'; 
      
                                    echo '<a href="'. get_permalink($id) .'" class="portfolio-card__link _icon-link"><span>Узнать больше</span></a>';
                                 echo '</div>';
                              echo '</div>';
                           echo '</div>';
                        endforeach;
                     echo '</div>';
                     echo '<div class="swiper__arrow swiper__arrow_right _icon-slider-arrow"></div>';
                     echo '<div class="swiper-pagination"></div>';
                  echo '</div>';
               endif;
            echo '</div>';

            echo '<div id="order" class="order">';
					echo '<div class="order__container">';
						echo '<div class="order__wrapper">';
							echo '<div class="order__text _content">'. $orderText .'</div>';

							echo '<div class="order__form">';
								echo do_shortcode('[contact-form-7 id="157" title="Запрос примера экспертизы"]');
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
         echo '</section>';
      elseif ($block['acf_fc_layout'] == 'template5') :
         $heading = $block['certificates_heading'];
         $heading != '' ? '' : $heading = get_field('certificates_heading', 'options');
         $items = $block['certificates_items'];
         $items != '' ? '' : $items = get_field('certificates_items', 'options');

         echo '<section id="certificates-' . $i . '" class="certificates">';
            echo '<div class="certificates__container">';
               echo '<div class="certificates_heading heading-bg">';
                  echo '<div class="_content">'. $heading .'</div>';
                  echo '<div class="heading-bg__icon"><img src="'. get_template_directory_uri() .'/dist/img/main/certificates-icon.svg" alt=""></div>';
               echo '</div>';

               echo '<div class="certificates__items" data-gallery>';
                  foreach ($items as $item) :
                     echo '<div class="certificates__item" data-src="'. $item['url'] .'"><img src="'. $item['url'] .'" alt="'. $item['alt'] .'" loading="lazy"></div>';
                  endforeach;
					echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif ($block['acf_fc_layout'] == 'template6') :
         $heading = $block['news-widget_heading'];
         $my_posts = get_posts( array(
            'numberposts' => -1,
            'category'    => 0,
            'orderby'     => 'date',
            'order'       => 'DESC',
            'include'     => array(),
            'exclude'     => array(),
            'meta_key'    => '',
            'meta_value'  =>'',
            'post_type'   => 'blog',
            'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
         ) );


         if ($my_posts) :
            echo '<section id="news-widget-' . $i . '" class="news-widget">';
               echo '<div class="news-widget__container">';
                  echo $heading != '' ? '<div class="news-widget__heading _content">' . $heading . '</div>' : '';
   
                  echo '<div class="news-widget__slider swiper">';
                     echo '<div class="swiper__arrow swiper__arrow_left _icon-slider-arrow"></div>';
   
                     echo '<div class="news-widget__wrapper swiper-wrapper">';
                        foreach ($my_posts as $item) :
                           $id = $item->ID;
                           echo '<article class="news-widget__slide swiper-slide news-card">';
                              echo '<a href="'. get_permalink($id) .'" class="news-card__title">'. get_the_title($id) .'</a>';
                              echo '<div class="news-card__excerpt _content">'. get_the_excerpt($id) .'</div>';
                              echo '<a href="'. get_permalink($id) .'" class="news-card__link">';
                                 echo '<i class="_icon-link"></i>';
                                 echo '<span>Читать далее</span>';
                              echo '</a>';
                           echo '</article>';
                        endforeach; 
                     echo '</div>';
   
                     echo '<div class="swiper__arrow swiper__arrow_right _icon-slider-arrow"></div>';
                     echo '<div class="swiper-pagination"></div>';
                  echo '</div>';
               echo '</div>';
            echo '</section>';
         endif;

      elseif ($block['acf_fc_layout'] == 'template7') :
         $mapBG = $block['map_bg'];

         echo '<section id="map-' . $i . '" class="map">';
            echo '<a href="https://yandex.ru/maps/-/CCUvvWuUWD" target="_blank" class="map__bg"><img src="'. $mapBG['url'] .'" alt="'. $mapBG['alt'] .'"></a>';

            echo '<div class="map__container">';
               echo '<div class="map__wrapper">';
                  echo '<div class="map__company">';
                  $footerLogo = get_field('footer-logo', 'options');
                     echo '<div  class="map__logo"><img src="'. $footerLogo['url'] .'" alt="'. $footerLogo['alt'] .'"></div>';
                     echo '<div class="map__text">'. get_bloginfo('description') .'</div>';
                  echo '</div>';

                  $contacts = get_field('contacts', 'options');
                  $addresses = $contacts['addresses'];
                  echo '<div class="map__contacts contacts">';
                     if ($addresses) :
                        echo '<div class="contacts__group">';
                           echo '<div class="contacts__title">Наш адрес:</div>';

                           foreach ($addresses as $item) :
                              $address = $item['address'];

                              echo '<div class="contacts__item contacts__item_address">';
                                 echo '<a href="'. $address['url'] .'" target="'. $address['target'] .'">'. $address['title'] .'</a>';
                              echo '</div>';
                           endforeach;
                        echo '</div>';
                     endif;
                  echo '</div>';
               echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif ($block['acf_fc_layout'] == 'template7-2') :
         $script = $block['map2_script'];
         $script != '' ? '' : $script = get_field('map2_script', 'options');

         echo '<section id="map2-' . $i . '" class="map2">';
            echo $script;
         echo '</section>';
      elseif ($block['acf_fc_layout'] == 'template8') :
         $text = $block['single-content'];

         echo '<section id="single-content-' . $i . '" class="single-content">';
            echo '<div class="single-content__container">';
               echo '<div class="_content">'. $text .'</div>';
            echo '</div>';
         echo '</section>';
      elseif ($block['acf_fc_layout'] == 'template9') :
         $heading = $block['template9_heading'];
         $bgColor = $block['template9_bg-color'];
         $items = $block['template9_items'];

         echo '<section id="template9-' . $i . '" class="template9" style="background-color: '. $bgColor .';">';
            echo '<div class="template9__container">';
               echo $heading != '' ? '<div class="template9__heading _heading _content">' . $heading . '</div>' : '';

               echo '<div class="template9__items">';
                  foreach ($items as $item) :
                     $itemImg = $item['template9_item-img'];
                     $itemCaption = $item['template9_item-caption'];

                     echo '<div class="template9__item">';
                        echo '<div class="template9__item-img"><img src="'. $itemImg['url'] .'" alt="'. $itemImg['alt'] .'"></div>';
                        echo '<div class="template9__item-caption">'. $itemCaption .'</div>';
                     echo '</div>';
                  endforeach;
               echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif ($block['acf_fc_layout'] == 'template10') :
         $heading = $block['licenses_heading'];
         $rows = $block['licenses_row'];

         echo '<section id="licenses-' . $i . '" class="licenses">';
            echo '<div class="licenses__container">';
               echo $heading != '' ? '<div class="licenses__heading _heading _content">' . $heading . '</div>' : '';

               echo '<div class="licenses__rows">';
                  foreach ($rows as $row) :
                     $rowCaption = $row['licenses_caption'];
                     $rowSlider = $row['licenses_slider'];

                     echo '<div class="licenses__row">';
                        echo $rowCaption != '' ? '<h3 class="licenses__caption">' . $rowCaption . '</h3>' : '';

                        echo '<div class="licenses__slider swiper">';
                           echo '<div class="swiper__arrow swiper__arrow_left _icon-slider-arrow"></div>';
                           echo '<div class="licenses__wrapper swiper-wrapper">';
                              foreach ($rowSlider as $item) :
                                 $itemImage = $item['licenses-card_img'];
                                 $itemName = $item['licenses-card_name'];

                                 echo '<div class="licenses__slide swiper-slide licenses-card">';
                                    if ($itemImage) :
                                       echo '<div class="licenses-card__img" data-gallery><img src="'. $itemImage['url'] .'" alt="'. $itemImage['alt'] .'"></div>';
                                    else :
                                       echo '<div class="no-photo"> <i class="_icon-no-photo"></i> </div>';
                                    endif;
                                    echo '<a href="'. $itemName['url'] .'" class="licenses-card__name" target="'. $itemName['target'] .'">'. $itemName['title'] .'</a>';
                                 echo '</div>';
                              endforeach;
                           echo '</div>';
                           echo '<div class="swiper__arrow swiper__arrow_right _icon-slider-arrow"></div>';
                           echo '<div class="swiper-pagination"></div>';
                        echo '</div>';
                     echo '</div>';
                  endforeach;
               echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif ($block['acf_fc_layout'] == 'template11') :
         $heading = $block['template11_heading'];
         $table = $block['template11_table'];

         echo '<section id="single-content-' . $i . '" class="single-content">';
            echo '<div class="single-content__container">';
               echo $heading != '' ? '<div class="single-content__heading _heading _content">' . $heading . '</div>' : '';

               if ($table) :
                  echo '<div class="_content">';
                     echo '<figure class="wp-block-table">';
                        echo '<table>';
                           if (!empty( $table['header'])) :
                              echo '<thead>';
                                 echo '<tr>';
                                    foreach ($table['header'] as $th) :
                                       echo '<th>'. $th['c'] .'</th>';
                                    endforeach;
                                 echo '</tr>';
                           echo '</thead>';
                           endif;
                           
                           echo '<tbody>';
                              foreach ($table['body'] as $tr) :
                                 echo '<tr>';
                                    foreach ($tr as $td) :
                                       echo '<td>'. $td['c'] .'</td>';
                                    endforeach;
                                 echo '</tr>';
                              endforeach;
                           echo '</tbody>';
                        echo '</table>';
                        echo $table['caption'] != '' ? '<figcaption class="wp-element-caption">'. $table['caption'] .'</figcaption>' : '';
                     echo '</figure>';
                  echo '</div>';
               endif;
            echo '</div>';
         echo '</section>';
      elseif ($block['acf_fc_layout'] == 'template12') :
         $template = $block['order_template'];
         if ($template == "Шаблон 1") :
            $class = "";
         elseif ($template == "Шаблон 2"):
            $class = "order_second";
         endif;
         $text = $block['order_text'];
         $text != '' ? '' : $text = get_field('order_text', 'options');

         echo '<section id="order-' . $i . '" class="order '. $class .'">';
            echo '<div class="order__container">';
               echo '<div class="order__wrapper">';
                  echo $text != '' ? '<div class="order__text _content">' . $text . '</div>' : '';

                  echo '<div class="order__form">';
                     echo do_shortcode('[contact-form-7 id="157" title="Запрос примера экспертизы"]');
                  echo '</div>';
               echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif ($block['acf_fc_layout'] == 'template13') :
         $text = $block['request_text'];

         echo '<section id="request-' . $i . '" class="request">';
            echo '<div class="request__container">';
               echo $text != '' ? '<div class="request__text _content">' . $text . '</div>' : '';

               echo '<div class="request__form">';
                  echo do_shortcode('[contact-form-7 id="256" title="Оставьте ваши контакты"]');
               echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif ($block['acf_fc_layout'] == 'template14') :
         $heading = $block['contacts-main_heading'];
         $right = $block['contacts-main_right'];

         echo '<section id="contacts-main-' . $i . '" class="contacts-main">';
            echo '<div class="contacts-main__container">';
               echo $heading != '' ? '<div class="contacts-main__heading _content">' . $heading . '</div>' : '';

               echo '<div class="contacts-main__row">';
                  echo '<div class="contacts-main__left">';
                     $contacts = get_field('contacts', 'options');
                     echo '<div class="contacts">';
                        $addresses = $contacts['addresses'];
                        if ($addresses) :
                           echo '<div class="contacts__group">';
                              echo '<div class="contacts__title">Наш адрес:</div>';
   
                              foreach ($addresses as $item) :
                                 $address = $item['address'];
   
                                 echo '<div class="contacts__item contacts__item_address">';
                                    echo '<a href="'. $address['url'] .'" target="'. $address['target'] .'">'. $address['title'] .'</a>';
                                 echo '</div>';
                              endforeach;
                           echo '</div>';
                        endif;
                        
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

                        $messengers = $contacts['messengers'];
                        $telegram = $messengers['telegram'];
                        $whatsapp = $messengers['whatsapp'];
                        $viber = $messengers['viber'];
                        if ($telegram || $whatsapp || $viber) :
                           echo '<div class="contacts__group">';
                              echo '<div class="socials">';
                                 echo $telegram != '' ? '<div class="socials__item"><a href="'. $telegram .'" class="_icon-telegram"></a></div>' : '';
                                 echo $whatsapp != '' ? '<div class="socials__item"><a href="'. $whatsapp .'" class="_icon-whatsapp"></a></div>' : '';
                                 echo $viber != '' ? '<div class="socials__item"><a href="'. $viber .'" class="_icon-viber"></a></div>' : '';
                              echo '</div>';
                           echo '</div>';
                        endif;

                        $socials = $contacts['socials'];
                        $yandex = $socials['yandex'];
                        $odnoklassniki = $socials['odnoklassniki'];
                        $vk = $socials['vk'];
                        $instagram = $socials['instagram'];
                        $facebook = $socials['facebook'];

                        if ($yandex || $odnoklassniki || $vk || $instagram || $facebook) :
                           echo '<div class="contacts__group">';
                              echo '<div class="contacts__caption">Мы в соцсетях:</div>';
   
                              echo '<div class="socials">';
                                 echo $yandex != '' ? '<div class="socials__item"><a href="'. $yandex .'" class="_icon-yandex"></a></div>' : '';
                                 echo $odnoklassniki != '' ? '<div class="socials__item"><a href="'. $odnoklassniki .'" class="_icon-odnoklassniki"></a></div>' : '';
                                 echo $vk != '' ? '<div class="socials__item"><a href="'. $vk .'" class="_icon-vk"></a></div>' : '';
                                 echo $instagram != '' ? '<div class="socials__item"><a href="'. $instagram .'" class="_icon-instagram"></a></div>' : '';
                                 echo $facebook != '' ? '<div class="socials__item"><a href="'. $facebook .'" class="_icon-facebook"></a></div>' : '';
                              echo '</div>';
                           echo '</div>';
                        endif;
                     echo '</div>';
                  echo '</div>';
                  echo '<div class="contacts-main__right">';
                     echo '<div class="_content">'. $right .'</div>';
                  echo '</div>';
               echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif ($block['acf_fc_layout'] == 'template15') :
         $heading = $block['equipment_heading'];
         $items = $block['equipment_items'];

         echo '<section id="equipment-' . $i . '" class="equipment">';
            echo '<div class="equipment__container">';
               echo $heading != '' ? '<div class="equipment__heading _content">' . $heading . '</div>' : '';

               if ($items) :
                  echo '<div class="equipment__items">';
                     foreach ($items as $card) :
                        $cardBg = $card['equipment-card_bg'];
                        $cardImage = $card['equipment-card_image'];
                        $cardCategory = $card['equipment-card_category'];
                        $cardName = $card['equipment-card_name'];

                        echo '<div class="equipment__card equipment-card">';
                           echo '<div class="equipment-card__img">';
                              echo '<img src="'. $cardImage['url'] .'" alt="'. $cardImage['alt'] .'">';
                              echo '<div class="equipment-card__bg" style="background-color: '. $cardBg .'"></div>';
                           echo '</div>';
                           echo '<div class="equipment-card__body">';
                              echo '<div class="equipment-card__category">'. $cardCategory .'</div>';
                              echo '<div class="equipment-card__name">'. $cardName .'</div>';
                           echo '</div>';
                        echo '</div>';
                     endforeach; 
                  echo '</div>';
               endif;
            echo '</div>';
         echo '</section>';
      elseif ($block['acf_fc_layout'] == 'template16') :
         $heading = $block['clients_heading'];
         $slider = $block['clients_slider'];

         echo '<section id="clients-' . $i . '" class="clients">';
            echo '<div class="clients__container">';
               echo $heading != '' ? '<div class="clients__heading _heading _content">' . $heading . '</div>' : '';

               echo '<div class="clients__slider swiper">';
						echo '<div class="swiper__arrow swiper__arrow_left _icon-slider-arrow"></div>';

						echo '<div class="clients__wrapper swiper-wrapper">';
                     foreach ($slider as $client) :
                        $client_image = $client['client_image'];

                        echo '<div class="clients__slide swiper-slide"><img src="'. $client_image['url'] .'" alt="'. $client_image['alt'] .'"></div>';
                     endforeach;
						echo '</div>';
						echo '<div class="swiper__arrow swiper__arrow_right _icon-slider-arrow"></div>';
					echo '</div>';
            echo '</div>';
         echo '</section>';
      elseif ($block['acf_fc_layout'] == 'template0') :
         $heading = $block['template0_heading'];

         echo '<section id="template0-' . $i . '" class="template0">';
            echo '<div class="template0__container">';
               echo $heading != '' ? '<div class="template0__heading _content">' . $heading . '</div>' : '';
            echo '</div>';
         echo '</section>';
      endif;

      $i++;
   endforeach;
endif;

if (get_the_content()) :
   echo '<section id="single-content" class="single-content">';
      echo '<div class="single-content__container">';
         echo '<div class="_content">';
            the_content();
         echo '</div>';
      echo '</div>';
   echo '</section>';
endif;
