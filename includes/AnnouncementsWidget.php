<?php
require_once BEEVI_PATH.'includes/BaseWidget.php';

class AnnouncementsWidget extends BaseWidget {
  function AnnouncementsWidget() {
    parent::BaseWidget('AnnouncementsWidget', 'The latest news for your club', 'Beevi::News', 'News');
  }
 
  function content(){
    date_default_timezone_set("US/Eastern");
    setlocale(LC_TIME, "fr_FR.UTF-8");

    // Display all the announcements
    $announcements = json_decode(CallAPI($this->api_url."/announcements", array(
        "expand" => true, 
        "sortproperty" => "id", 
        "sortdirection" => "desc",
        "limit" => $this->limit
    ), $this->api_key)); 
    echo "<ul>" ;
    foreach ($announcements as $announcement){
      echo "<li>".strftime("%e %B %G @ %H:%M", strtotime($announcement->created_at))."<br><a href='http://app.beevi.co'>$announcement->title</a></li>";
    }
    echo "</ul>";
  }
}
?>