<?php
/*
* Plugin Name: Daft Plugin
* Version: 0.1
* Description: Displays selected property results from daft.ie
* Author: Diego Solorzano & Joan Healy
* Author URI: http://gorilla-systems.com/
* Plugin URI: http://gorilla-systems.com/
*/  
include_once dirname( __FILE__ ) . '/helper.php'; 

function display_results($atts, $content = null) {
    $helper = new DaftSearchHelper();
    $helper->loadResults();		
}

 
add_shortcode('daftsearch', 'display_results');

?>