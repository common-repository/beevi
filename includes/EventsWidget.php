<?php
require_once BEEVI_PATH.'includes/BaseWidget.php';

class EventsWidget extends BaseWidget {
  function EventsWidget() {
    parent::BaseWidget('EventsWidget', 'Upcoming events for your club', 'Beevi::Calendar', 'Calendar');
  }
 
  function content(){
    date_default_timezone_set("US/Eastern");
    setlocale(LC_TIME, "fr_FR.UTF-8");

    //http://192.168.99.100:5000/api/organizations/1/events

    // Display all the announcements
    $announcements = json_decode(CallAPI($this->api_url."/events/upcoming", array(
        "expand" => true, 
        "limit" => $this->limit
    ), $this->api_key)); 
    echo "<ul>" ;
    foreach ($announcements as $announcement){
        $s = "<li>";
        if ($announcement->status == "cancelled"){
            $s .= "<s>";
        }
        $s .=  strftime("%e %B %G @ %H:%M", strtotime($announcement->dtstart)) . "<br><a href='http://app.beevi.co'>$announcement->summary</a>";
        if ($announcement->status == "cancelled"){
            $s .= "</s> <span style='color:red;'>annulé</span>";
        }

        echo <<<EOT
                $s
                </li>
EOT;

    }
    echo "</ul>";
  }
}
?>