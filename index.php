<?php 
get_header(); 

echo '<main class="page">';
	if (!is_home()) :
		kama_breadcrumbs('');
	endif;
	
	include 'blocks.php';
echo '</main>';

get_footer();