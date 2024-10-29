<?php
require_once BEEVI_PATH.'includes/CallAPI.php';

abstract class BaseWidget extends WP_Widget {
  var $api_url = "https://beevi-api.herokuapp.com/api";
  //var $api_url = "http://192.168.99.100:5000/api";
  var $api_key;
  var $placeholder;
  var $limit;

  function BaseWidget($classname, $description, $long_description, $placeholder) {
    $widget_ops = array('classname' => $classname, 'description' => $description );
    $this->WP_Widget($classname, $long_description, $widget_ops);
    $this->placeholder = $placeholder;

    $options = get_option(OPTION_NAME);
    $this->api_key = $options['api_key'];
  }
 
  function form($instance) {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'limit' => 5 ) );
    $title = $instance['title'];
    $limit = $instance['limit'];

    echo "<p><label for=\"".$this->get_field_id('title')."\">";
    echo "Title: <input class=\"widefat\" id=\"".$this->get_field_id('title')."\" name=\"".$this->get_field_name('title')."\" type=\"text\" value=\"".attribute_escape($title)."\" placeholder=\"".$this->placeholder."\">";
    echo "</label></p>";

    echo "<p><label for=\"".$this->get_field_id('limit')."\">";
    echo "Nb d'items à afficher: <input class=\"widefat\" id=\"".$this->get_field_id('limit')."\" name=\"".$this->get_field_name('limit')."\" type=\"text\" value=\"".attribute_escape($limit)."\" placeholder=\"5\">";
    echo "</label></p>";
  }
 
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['limit'] = $new_instance['limit'];
    return $instance;
  }

  abstract function content();
 
  function widget($args, $instance) {
    extract($args, EXTR_SKIP);

    $this->limit = empty($instance['limit']) ? 5 : $instance['limit'];
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;;
    
    $this->content();
 
    echo $after_widget;
  }
}
?>