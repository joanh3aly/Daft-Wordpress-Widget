<?php
/*
Plugin Name: Daft Search Widget
Plugin URI: http://www.gorilla-systems.com/
Description: Search form for Daft properties to display on your sidebar
Author: Joan Healy, Diego Solorzano
Version: 1
Author URI: http://www.gorilla-systems.com/
*/
 
include_once dirname( __FILE__ ) . '/helper.php'; 


class DaftSearchWidget extends WP_Widget
{
  function DaftSearchWidget()
  {
    $widget_ops = array('classname' => 'DaftSearchWidget', 'description' => 'Search form for Daft properties to display on your sidebar' );
    $this->WP_Widget('DaftSearchWidget', 'Daft Property Search', $widget_ops);
  }

  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) ); 
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php  
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);  
    echo $before_widget;  
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']); 
 
    if (!empty($title))
    {
        echo $before_title . $title . $after_title;
    }
 
    /*
     * Execute the Daft widget (all code in the helper class and views)
     * Other than the 2 lines below, the rest of this code is wordpress standard widget 
     * building code
     * 
     */
    $helper = new DaftSearchHelper();
    $helper->loadWidget();
    
    echo $after_widget;
    
  }
 
}
/*
 * Admin section
 */
function daft_widget_admin() {  
   include('daft_widget_admin.php');  
}  
function widget_admin_actions() {  
    add_options_page("Daft Widget Settings", "Daft Widget Settings", 1, "root", "daft_widget_admin");
}  
add_action('admin_menu', 'widget_admin_actions');  
/*
 * end of admin section
 */
add_action( 'widgets_init', create_function('', 'return register_widget("DaftSearchWidget");') ); 
?>