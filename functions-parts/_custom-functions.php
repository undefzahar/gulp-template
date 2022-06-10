<?php
function isMobile() {
  $detect = new Mobile_Detect;
  return $detect->isMobile(); 
}
function isTablet() {
  $detect = new Mobile_Detect;
  return $detect->isTablet(); 
}
function isDesktop() {
  return (!isTablet() && !isMobile());
}

# Получить название текущего шаблона
function get_current_template() {
  global $template;
  return basename($template);
}

# Условие для страницы и её дочерних
function is_tree($pid) {
	global $post;   
    $page = get_page_by_path( $pid );
    $page_id = $page->ID;

	if(is_page()&&($post->post_parent==$page_id||is_page($pid))) 
    return true;
	else 
    return false;
};


# Шаблон поиска
// add_filter( 'get_search_form', 'my_search_form' );
// function my_search_form( $form ) {

// 	$form = '
// 	<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
// 		<input placeholder="'.get_field('search_title','options').'" type="text" value="' . get_search_query() . '" name="s" id="s" />
// 		<input type="submit" id="searchsubmit"  value="" />
// 	</form>';

// 	return $form;
// }