<?php

/**
 * niko functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package niko
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

if (!function_exists('niko_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function niko_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on niko, use a find and replace
		 * to change 'niko' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('niko', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'header' => esc_html__('Header menu', 'niko'),
				'footer' => esc_html__('Footer menu', 'niko'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');
	}
endif;
add_action('after_setup_theme', 'niko_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function niko_content_width()
{
	$GLOBALS['content_width'] = apply_filters('niko_content_width', 640);
}
add_action('after_setup_theme', 'niko_content_width', 0);

/**
 * Enqueue scripts and styles.
 */
function niko_scripts()
{
	wp_enqueue_style('niko-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_enqueue_style('niko-stylesheet', get_template_directory_uri() . '/dist/css/style.min.css', array(), _S_VERSION);

	wp_enqueue_script('niko-custom-js', get_template_directory_uri() . '/dist/js/app.min.js', '', _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'niko_scripts');

// Выводим настройки в меню админки
if (function_exists('acf_add_options_page')) {
	// Main Theme Settings Page
	$parent = acf_add_options_page(array(
		'page_title' => 'Theme settings',
		'menu_title' => 'Theme settings',
		'redirect'   => 'Theme Settings',
	));
	acf_add_options_sub_page(array(
		'page_title' => 'Theme settings',
		'menu_title' => 'Theme settings',
		'menu_slug'  => "acf-options",
		'parent'     => $parent['menu_slug']
	));
	acf_add_options_sub_page(array(
		'page_title' => 'Repeating blocks',
		'menu_title' => 'Repeating blocks',
		'parent'     => $parent['menu_slug']
	));
}

// Изменяем стартовую высоту textarea в advanced custom field
function PREFIX_apply_acf_modifications()
{
?>
	<style>
		.acf-editor-wrap iframe {
			min-height: 0;
		}
	</style>
	<script>
		(function($) {
			// (filter called before the tinyMCE instance is created)
			acf.add_filter('wysiwyg_tinymce_settings', function(mceInit, id, $field) {
				// enable autoresizing of the WYSIWYG editor
				mceInit.wp_autoresize_on = true;
				return mceInit;
			});
			// (action called when a WYSIWYG tinymce element has been initialized)
			acf.add_action('wysiwyg_tinymce_init', function(ed, id, mceInit, $field) {
				// reduce tinymce's min-height settings
				ed.settings.autoresize_min_height = 130;
				// reduce iframe's 'height' style to match tinymce settings
				$('.acf-editor-wrap iframe').css('height', '130px');
			});
		})(jQuery)
	</script>
<?php
}
add_action('acf/input/admin_footer', 'PREFIX_apply_acf_modifications');

// Отключение Emoji в WordPress
function disable_emojis()
{
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}
add_action('init', 'disable_emojis');
function disable_emojis_tinymce($plugins)
{
	if (is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}

// Удаление стилей и скриптов wordpress по умолчанию
function wpassist_remove_block_library_css()
{
	wp_dequeue_style('global-styles');
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
	wp_dequeue_style('wc-blocks-style');
	wp_dequeue_style('woocommerce-general');
	wp_dequeue_style('woocommerce-layout');
	wp_dequeue_style('woocommerce-smallscreen');
	wp_dequeue_style('font-awesome');
	wp_dequeue_style('yith-wcwl-main');

	wp_dequeue_script('prettyPhoto');
	wp_dequeue_script('prettyPhoto-init');
}
add_action('wp_enqueue_scripts', 'wpassist_remove_block_library_css');

remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

function agentwp_dequeue_stylesandscripts()
{
	if (class_exists('woocommerce')) {
		wp_dequeue_style('selectWoo');
		wp_deregister_style('selectWoo');

		wp_dequeue_script('selectWoo');
		wp_deregister_script('selectWoo');

		wp_dequeue_script('wc-country-select');
	}
}

// Удаляем <p> и <br/> из Contact Form 7
add_filter('wpcf7_autop_or_not', '__return_false');

/* Меняем у excerpt '[...]' на '...' */
add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($more)
{
	global $post;
	return '...';
}

// Удаляем аттрибут role и тэг h2 
function sanitize_pagination($content)
{
	$content = str_replace('navigation', '', $content);
	$content = preg_replace('#<h2.*?>(.*?)<\/h2>#si', '', $content);

	return $content;
}

// Меняем вывод меню
add_action('navigation_markup_template', 'sanitize_pagination');
class My_Walker_Nav_Menu extends Walker_Nav_Menu
{
	// add classes to ul sub-menus
	function start_lvl(&$output, $depth = 0, $args = NULL)
	{
		// depth dependent classes
		$indent = ($depth > 0  ? str_repeat("\t", $depth) : ''); // code indent
		$display_depth = ($depth + 1); // because it counts the first submenu as 0
		$classes = array(
			'sub-menu',
			($display_depth % 2  ? 'menu-odd' : 'menu-even'),
			($display_depth >= 2 ? 'sub-sub-menu' : ''),
			'menu-depth-' . $display_depth
		);
		$class_names = implode(' ', $classes);

		// build html
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}

	// add main/sub classes to li's and links
	function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
	{
		global $wp_query;

		// Restores the more descriptive, specific name for use within this method.
		$item = $data_object;

		$indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent

		// depth dependent classes
		$depth_classes = array(
			($depth == 0 ? 'main-menu-item' : 'sub-menu-item'),
			($depth >= 2 ? 'sub-sub-menu-item' : ''),
			($depth % 2 ? 'menu-item-odd' : 'menu-item-even'),
			'menu-item-depth-' . $depth
		);
		$depth_class_names = esc_attr(implode(' ', $depth_classes));

		// passed classes
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));

		// build html
		$output .= $indent . '<li id="nav-menu-item-' . $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

		// link attributes
		$attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
		$attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
		$attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
		$attributes .= !empty($item->url)        ? ' href="'   . esc_attr($item->url) . '"' : '';
		$attributes .= ' class="menu-link ' . ($depth > 0 ? 'sub-menu-link' : 'main-menu-link') . '"';

		$item_output = sprintf(
			'%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
			$args->before,
			$attributes,
			$args->link_before,
			apply_filters('the_title', $item->title, $item->ID),
			$args->link_after,
			$args->after
		);

		// build html
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
}

// Создаем свои типы данных
add_action('init', 'register_post_types');
function register_post_types()
{
	register_post_type('services', [
		'label'  => null,
		'labels' => [
			'name'               => 'Услуги', // основное название для типа записи
			'singular_name'      => 'Услуги', // название для одной записи этого типа
			'add_new'            => 'Добавить услугу', // для добавления новой записи
			'add_new_item'       => 'Добавить услугу', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать', // для редактирования типа записи
			'new_item'           => 'Новая услуга', // текст новой записи
			'view_item'          => 'Смотреть запись', // для просмотра записи этого типа.
			'search_items'       => 'Искать', // для поиска по этим типам записи
			'not_found'          => 'Ничего не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Ничего не найдено', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Услуги', // название меню
		],
		'description'         => 'Услуги',
		'public'              => true,
		'show_in_menu'        => true, // показывать ли в меню адмнки
		'rest_base'           => null, // $post_type. C WP 4.7
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-welcome-write-blog',
		'hierarchical'        => true,
		'show_in_rest'		  => true,
		'supports'            => ['title', 'custom-fields', 'excerpt',], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => ['theme'],
		'has_archive'         => true,
		'rewrite'             => true,
		'query_var'           => true,
	]);
	register_post_type('blog', [
		'label'  => null,
		'labels' => [
			'name'               => 'Новости', // основное название для типа записи
			'singular_name'      => 'Новости', // название для одной записи этого типа
			'add_new'            => 'Добавить новость', // для добавления новой записи
			'add_new_item'       => 'Добавить новость', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать', // для редактирования типа записи
			'new_item'           => 'Новая новость', // текст новой записи
			'view_item'          => 'Смотреть запись', // для просмотра записи этого типа.
			'search_items'       => 'Искать', // для поиска по этим типам записи
			'not_found'          => 'Ничего не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Ничего не найдено', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Новости', // название меню
		],
		'description'         => 'Новости',
		'public'              => true,
		'show_in_menu'        => true, // показывать ли в меню адмнки
		'rest_base'           => null, // $post_type. C WP 4.7
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-welcome-write-blog',
		'hierarchical'        => true,
		'show_in_rest'		  => true,
		'supports'            => ['title', 'editor', 'excerpt', ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => [],
		'has_archive'         => true,
		'rewrite'             => true,
		'query_var'           => true,
	]);
}

// Создаем таксономии
add_action('init', 'create_taxonomy');
function create_taxonomy()
{
	register_taxonomy('theme', ['services'], [
		'label'                 => '',
		'labels'                => [
			'name'              => 'Категория',
			'singular_name'     => 'Категория',
			'search_items'      => 'Искать',
			'all_items'         => 'Все категории',
			'view_item '        => 'Смотреть категорию',
			'parent_item'       => 'Родительская категория',
			'parent_item_colon' => 'Родительская категория',
			'edit_item'         => 'Редактировать',
			'update_item'       => 'Обновить',
			'add_new_item'      => 'Добавить новую',
			'new_item_name'     => 'Новая категория',
			'menu_name'         => 'Категории',
		],
		'description'           => 'Категории', // описание таксономии
		'public'                => true,
		'publicly_queryable'    => null, // равен аргументу public
		'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_menu'          => true, // равен аргументу show_ui
		'show_tagcloud'         => true, // равен аргументу show_ui
		'show_in_quick_edit'    => true, // равен аргументу show_ui
		'show_admin_column'		=> true,
		'show_in_rest'			=> true,
		'hierarchical'          => false,
		'rewrite'               => true,
	]);
}

// Прячем поле Description в таксономии Theme
function hide_description_row() {
	echo "<style> .term-description-wrap { display:none; } </style>";
}

add_action( "theme_edit_form", 'hide_description_row');
add_action( "theme_add_form", 'hide_description_row');

// Хлебные крошки
/**
 * Хлебные крошки для WordPress (breadcrumbs)
 *
 * @param  string [$sep  = '']      Разделитель. По умолчанию ' » '
 * @param  array  [$l10n = array()] Для локализации. См. переменную $default_l10n.
 * @param  array  [$args = array()] Опции. См. переменную $def_args
 * @return string Выводит на экран HTML код
 *
 * version 3.3.2
 */
function kama_breadcrumbs($sep = ' » ', $l10n = array(), $args = array())
{
	$kb = new Kama_Breadcrumbs;
	echo $kb->get_crumbs($sep, $l10n, $args);
}

class Kama_Breadcrumbs
{

	public $arg;

	// Локализация
	static $l10n = array(
		'home'       => 'Главная',
		'paged'      => 'Страница %d',
		'_404'       => 'Ошибка 404',
		'search'     => 'Результат - <b>%s</b>',
		'author'     => 'Автор: <b>%s</b>',
		'year'       => 'Архив за <b>%d</b> год',
		'month'      => 'Архив за: <b>%s</b>',
		'day'        => '',
		'attachment' => 'Галерея: %s',
		'tag'        => 'Records by tag: <b>%s</b>',
		'tax_tag'    => '%3$s',
		// tax_tag выведет: 'тип_записи из "название_таксы" по тегу: имя_термина'.
		// Если нужны отдельные холдеры, например только имя термина, пишем так: 'записи по тегу: %3$s'
	);

	// Параметры по умолчанию
	static $args = array(
		'on_front_page'   => true,  // выводить крошки на главной странице
		'show_post_title' => true,  // показывать ли название записи в конце (последний элемент). Для записей, страниц, вложений
		'show_term_title' => true,  // показывать ли название элемента таксономии в конце (последний элемент). Для меток, рубрик и других такс
		'title_patt'      => '<span class="site-breadcrumbs__title">%s</span>', // шаблон для последнего заголовка. Если включено: show_post_title или show_term_title
		'last_sep'        => true,  // показывать последний разделитель, когда заголовок в конце не отображается
		'markup'          => 'schema.org', // 'markup' - микроразметка. Может быть: 'rdf.data-vocabulary.org', 'schema.org', '' - без микроразметки
		// или можно указать свой массив разметки:
		// array( 'wrappatt'=>'<div class="kama_breadcrumbs">%s</div>', 'linkpatt'=>'<a href="%s">%s</a>', 'sep_after'=>'', )
		'priority_tax'    => array('category'), // приоритетные таксономии, нужно когда запись в нескольких таксах
		'priority_terms'  => array(), // 'priority_terms' - приоритетные элементы таксономий, когда запись находится в нескольких элементах одной таксы одновременно.
		// Например: array( 'category'=>array(45,'term_name'), 'tax_name'=>array(1,2,'name') )
		// 'category' - такса для которой указываются приор. элементы: 45 - ID термина и 'term_name' - ярлык.
		// порядок 45 и 'term_name' имеет значение: чем раньше тем важнее. Все указанные термины важнее неуказанных...
		'nofollow' => false, // добавлять rel=nofollow к ссылкам?

		// служебные
		'sep'             => '',
		'linkpatt'        => '',
		'pg_end'          => '',
	);

	function get_crumbs($sep, $l10n, $args)
	{
		global $post, $wp_query, $wp_post_types;

		self::$args['sep'] = $sep;

		// Фильтрует дефолты и сливает
		$loc = (object) array_merge(apply_filters('kama_breadcrumbs_default_loc', self::$l10n), $l10n);
		$arg = (object) array_merge(apply_filters('kama_breadcrumbs_default_args', self::$args), $args);

		$arg->sep = '<span class="site-breadcrumbs__separator">' . $arg->sep . '</span>'; // дополним

		// упростим
		$sep = &$arg->sep;
		$this->arg = &$arg;

		// микроразметка ---
		if (1) {
			$mark = &$arg->markup;

			// Разметка по умолчанию
			if (!$mark) $mark = array(
				'wrappatt'  => '<div class="site-breadcrumbs">%s</div>',
				'linkpatt'  => '<a href="%s">%s</a>',
				'sep_after' => '',
			);
			// rdf
			elseif ($mark === 'rdf.data-vocabulary.org') $mark = array(
				'wrappatt'   => '<div class="site-breadcrumbs" prefix="v: http://rdf.data-vocabulary.org/#">%s</div>',
				'linkpatt'   => '<span class="site-breadcrumbs__link" typeof="v:Breadcrumb"><a href="%s" rel="v:url" property="v:title">%s</a>',
				'sep_after'  => '</span>', // закрываем span после разделителя!
			);
			// schema.org
			elseif ($mark === 'schema.org') $mark = array(
				'wrappatt'   => '<div class="site-breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList"><div class="site-breadcrumbs__container">%s</div></div>',
				'linkpatt'   => '<span class="site-breadcrumbs__link" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="%s" itemprop="item"><span itemprop="name">%s</span></a></span>',
				'sep_after'  => '',
			);

			elseif (!is_array($mark))
				die(__CLASS__ . ': "markup" parameter must be array...');

			$wrappatt  = $mark['wrappatt'];
			$arg->linkpatt  = $arg->nofollow ? str_replace('<a ', '<a rel="nofollow"', $mark['linkpatt']) : $mark['linkpatt'];
			$arg->sep      .= $mark['sep_after'] . "\n";
		}

		$linkpatt = $arg->linkpatt; // упростим

		$q_obj = get_queried_object();

		// может это архив пустой таксы?
		$ptype = null;
		if (empty($post)) {
			if (isset($q_obj->taxonomy))
				$ptype = &$wp_post_types[get_taxonomy($q_obj->taxonomy)->object_type[0]];
		} else $ptype = &$wp_post_types[$post->post_type];

		// paged
		$arg->pg_end = '';
		if (($paged_num = get_query_var('paged')) || ($paged_num = get_query_var('page')))
			$arg->pg_end = $sep . sprintf($loc->paged, (int) $paged_num);

		$pg_end = $arg->pg_end; // упростим

		$out = '';

		if (is_front_page()) {
			return $arg->on_front_page ? sprintf($wrappatt, ($paged_num ? sprintf($linkpatt, get_home_url(), $loc->home) . $pg_end : $loc->home)) : '';
		}
		// страница записей, когда для главной установлена отдельная страница.
		elseif (is_home()) {
			$out = $paged_num ? (sprintf($linkpatt, get_permalink($q_obj), esc_html($q_obj->post_title)) . $pg_end) : esc_html($q_obj->post_title);
		} elseif (is_404()) {
			$out = $loc->_404;
		} elseif (is_search()) {
			$out = sprintf($loc->search, esc_html($GLOBALS['s']));
		} elseif (is_author()) {
			$tit = sprintf($loc->author, esc_html($q_obj->display_name));
			$out = ($paged_num ? sprintf($linkpatt, get_author_posts_url($q_obj->ID, $q_obj->user_nicename) . $pg_end, $tit) : $tit);
		} elseif (is_year() || is_month() || is_day()) {
			$y_url  = get_year_link($year = get_the_time('Y'));

			if (is_year()) {
				$tit = sprintf($loc->year, $year);
				$out = ($paged_num ? sprintf($linkpatt, $y_url, $tit) . $pg_end : $tit);
			}
			// month day
			else {
				$y_link = sprintf($linkpatt, $y_url, $year);
				$m_url  = get_month_link($year, get_the_time('m'));

				if (is_month()) {
					$tit = sprintf($loc->month, get_the_time('F'));
					$out = $y_link . $sep . ($paged_num ? sprintf($linkpatt, $m_url, $tit) . $pg_end : $tit);
				} elseif (is_day()) {
					$m_link = sprintf($linkpatt, $m_url, get_the_time('F'));
					$out = $y_link . $sep . $m_link . $sep . get_the_time('l');
				}
			}
		}
		// Древовидные записи
		elseif (is_singular() && $ptype->hierarchical) {
			$out = $this->_add_title($this->_page_crumbs($post), $post);
		}
		// Таксы, плоские записи и вложения
		else {
			$term = $q_obj; // таксономии

			// определяем термин для записей (включая вложения attachments)
			if (is_singular()) {
				// изменим $post, чтобы определить термин родителя вложения
				if (is_attachment() && $post->post_parent) {
					$save_post = $post; // сохраним
					$post = get_post($post->post_parent);
				}

				// учитывает если вложения прикрепляются к таксам древовидным - все бывает :)
				$taxonomies = get_object_taxonomies($post->post_type);
				// оставим только древовидные и публичные, мало ли...
				$taxonomies = array_intersect($taxonomies, get_taxonomies(array('hierarchical' => true, 'public' => true)));

				if ($taxonomies) {
					// сортируем по приоритету
					if (!empty($arg->priority_tax)) {
						usort($taxonomies, function ($a, $b) use ($arg) {
							$a_index = array_search($a, $arg->priority_tax);
							if ($a_index === false) $a_index = 9999999;

							$b_index = array_search($b, $arg->priority_tax);
							if ($b_index === false) $b_index = 9999999;

							return ($b_index === $a_index) ? 0 : ($b_index < $a_index ? 1 : -1); // меньше индекс - выше
						});
					}

					// пробуем получить термины, в порядке приоритета такс
					foreach ($taxonomies as $taxname) {
						if ($terms = get_the_terms($post->ID, $taxname)) {
							// проверим приоритетные термины для таксы
							$prior_terms = &$arg->priority_terms[$taxname];
							if ($prior_terms && count($terms) > 2) {
								foreach ((array) $prior_terms as $term_id) {
									$filter_field = is_numeric($term_id) ? 'term_id' : 'slug';
									$_terms = wp_list_filter($terms, array($filter_field => $term_id));

									if ($_terms) {
										$term = array_shift($_terms);
										break;
									}
								}
							} else
								$term = array_shift($terms);

							break;
						}
					}
				}

				if (isset($save_post)) $post = $save_post; // вернем обратно (для вложений)
			}

			// вывод

			// все виды записей с терминами или термины
			if ($term && isset($term->term_id)) {
				$term = apply_filters('kama_breadcrumbs_term', $term);

				// attachment
				if (is_attachment()) {
					if (!$post->post_parent)
						$out = sprintf($loc->attachment, esc_html($post->post_title));
					else {
						if (!$out = apply_filters('attachment_tax_crumbs', '', $term, $this)) {
							$_crumbs    = $this->_tax_crumbs($term, 'self');
							$parent_tit = sprintf($linkpatt, get_permalink($post->post_parent), get_the_title($post->post_parent));
							$_out = implode($sep, array($_crumbs, $parent_tit));
							$out = $this->_add_title($_out, $post);
						}
					}
				}
				// single
				elseif (is_single()) {
					if (!$out = apply_filters('post_tax_crumbs', '', $term, $this)) {
						$_crumbs = $this->_tax_crumbs($term, 'self');
						$out = $this->_add_title($_crumbs, $post);
					}
				}
				// не древовидная такса (метки)
				elseif (!is_taxonomy_hierarchical($term->taxonomy)) {
					// метка
					if (is_tag())
						$out = $this->_add_title('', $term, sprintf($loc->tag, esc_html($term->name)));
					// такса
					elseif (is_tax()) {
						$post_label = $ptype->labels->name;
						$tax_label = $GLOBALS['wp_taxonomies'][$term->taxonomy]->labels->name;
						$out = $this->_add_title('', $term, sprintf($loc->tax_tag, $post_label, $tax_label, esc_html($term->name)));
					}
				}
				// древовидная такса (рибрики)
				else {
					if (!$out = apply_filters('term_tax_crumbs', '', $term, $this)) {
						$_crumbs = $this->_tax_crumbs($term, 'parent');
						$out = $this->_add_title($_crumbs, $term, esc_html($term->name));
					}
				}
			}
			// влоежния от записи без терминов
			elseif (is_attachment()) {
				$parent = get_post($post->post_parent);
				$parent_link = sprintf($linkpatt, get_permalink($parent), esc_html($parent->post_title));
				$_out = $parent_link;

				// вложение от записи древовидного типа записи
				if (is_post_type_hierarchical($parent->post_type)) {
					$parent_crumbs = $this->_page_crumbs($parent);
					$_out = implode($sep, array($parent_crumbs, $parent_link));
				}

				$out = $this->_add_title($_out, $post);
			}
			// записи без терминов
			elseif (is_singular()) {
				$out = $this->_add_title('', $post);
			}
		}

		// замена ссылки на архивную страницу для типа записи
		$home_after = apply_filters('kama_breadcrumbs_home_after', '', $linkpatt, $sep, $ptype);

		if ('' === $home_after) {
			// Ссылка на архивную страницу типа записи для: отдельных страниц этого типа; архивов этого типа; таксономий связанных с этим типом.
			if (
				$ptype && $ptype->has_archive && !in_array($ptype->name, array('post', 'page', 'attachment'))
				&& (is_post_type_archive() || is_singular() || (is_tax() && in_array($term->taxonomy, $ptype->taxonomies)))
			) {
				$pt_title = $ptype->labels->name;

				// первая страница архива типа записи
				if (is_post_type_archive() && !$paged_num)
					$home_after = sprintf($this->arg->title_patt, $pt_title);
				// singular, paged post_type_archive, tax
				else {
					$home_after = sprintf($linkpatt, get_post_type_archive_link($ptype->name), $pt_title);

					$home_after .= (($paged_num && !is_tax()) ? $pg_end : $sep); // пагинация
				}
			}
		}

		$before_out = sprintf($linkpatt, home_url(), $loc->home) . ($home_after ? $sep . $home_after : ($out ? $sep : ''));

		$out = apply_filters('kama_breadcrumbs_pre_out', $out, $sep, $loc, $arg);

		$out = sprintf($wrappatt, $before_out . $out);

		return apply_filters('kama_breadcrumbs', $out, $sep, $loc, $arg);
	}

	function _page_crumbs($post)
	{
		$parent = $post->post_parent;

		$crumbs = array();
		while ($parent) {
			$page = get_post($parent);
			$crumbs[] = sprintf($this->arg->linkpatt, get_permalink($page), esc_html($page->post_title));
			$parent = $page->post_parent;
		}

		return implode($this->arg->sep, array_reverse($crumbs));
	}

	function _tax_crumbs($term, $start_from = 'self')
	{
		$termlinks = array();
		$term_id = ($start_from === 'parent') ? $term->parent : $term->term_id;
		while ($term_id) {
			$term       = get_term($term_id, $term->taxonomy);
			$termlinks[] = sprintf($this->arg->linkpatt, get_term_link($term), esc_html($term->name));
			$term_id    = $term->parent;
		}

		if ($termlinks)
			return implode($this->arg->sep, array_reverse($termlinks)) /*. $this->arg->sep*/;
		return '';
	}

	// добалвяет заголовок к переданному тексту, с учетом всех опций. Добавляет разделитель в начало, если надо.
	function _add_title($add_to, $obj, $term_title = '')
	{
		$arg = &$this->arg; // упростим...
		$title = $term_title ? $term_title : esc_html($obj->post_title); // $term_title чиститься отдельно, теги моугт быть...
		$show_title = $term_title ? $arg->show_term_title : $arg->show_post_title;

		// пагинация
		if ($arg->pg_end) {
			$link = $term_title ? get_term_link($obj) : get_permalink($obj);
			$add_to .= ($add_to ? $arg->sep : '') . sprintf($arg->linkpatt, $link, $title) . $arg->pg_end;
		}
		// дополняем - ставим sep
		elseif ($add_to) {
			if ($show_title)
				$add_to .= $arg->sep . sprintf($arg->title_patt, $title);
			elseif ($arg->last_sep)
				$add_to .= $arg->sep;
		}
		// sep будет потом...
		elseif ($show_title)
			$add_to = sprintf($arg->title_patt, $title);

		return $add_to;
	}
}
