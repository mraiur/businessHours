<?php
$minutes = ( isset($_POST['minutes']) && $_POST['minutes']*1 > 0)?$_POST['minutes']*60:0;
$hours = ( isset($_POST['hours']) && $_POST['hours']*1 > 0)?$_POST['hours']*60*60:0;
$submitDate = ( isset($_POST['submitDate']) )?$_POST['submitDate']:false;

$responce = [
    'status' => 'ok',
    'result' => ''
];
if( ( $minutes > 0 || $hours > 0 ) && $submitDate){
    require "../src/Business/DaysOfWeek.php";
    require "../src/Business/HoursCalculator.php";

    $hoursCalculator = new Business\HoursCalculator("09:00", "15:00");
    $hoursCalculator->setOpeningHours(Business\DaysOfWeek::FRIDAY, "10:00", "17:00");
    $hoursCalculator->setOpeningHours("2010-12-24", "08:00", "13:00");
    $hoursCalculator->setClosed(Business\DaysOfWeek::SUNDAY, Business\DaysOfWeek::WEDNESDAY);
    $hoursCalculator->setClosed("2010-12-25");

    $responce['result'] = $hoursCalculator->calculateDeadline($hours+$minutes, $submitDate);
} else {
    $responce['status'] = 'error';
    $responce['result'] = 'Missing parameters';
}
echo json_encode($responce);