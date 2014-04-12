<?php
date_default_timezone_set('Europe/Amsterdam');
echo $now = date('m/d/Y g:i:s A');
$date1 = new DateTime($now);
$date2 = new DateTime("10/11/2013 06:00:00 AM");
$date3 = new DateTime("10/13/2013 01:33:00 PM");
if($date1 < $date3 && $date2 < $date1 ){ echo 'running'; } elseif($date1 > $date3 ) { echo 'closed'; } else { echo "coming soon"; }
//var_dump($date1 == $date2);

//var_dump($date1 > $date2);
?>
