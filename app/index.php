<?php
require_once dirname(__DIR__) .'/vendor/autoload.php';

$date_start = new \DateTime('2019-01-01');
$date_end = new \DateTime('2019-12-31');
       
$wc = new WC\WeightController(new WC\User(1));
$avg_data = $wc->getAvgWeightВetweenDates(
        $date_start, 
        $date_end, 
        WC\WeightController::BYWEEK
        );

echo "<pre>";
var_dump($avg_data);
echo "</pre>";