<?php
require_once dirname(__DIR__) .'/vendor/autoload.php';

$date_start = new \DateTime('2019-10-01');
$date_end = new \DateTime('2019-10-4');
       
$wc = new WC\WeightController(new WC\User(1));
$avg_data = $wc->getAvgWeightВetweenDates(
        WC\WeightController::BYWEEK,
        $date_start,
        $date_end
        );

echo($avg_data); 
