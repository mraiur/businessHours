<?php
require "src/Business/DaysOfWeek.php";
require "src/Business/HoursCalculator.php";

$t = new Business\HoursCalculator("09:00", "15:00");
$t->setOpeningHours(Business\DaysOfWeek::FRIDAY, "10:00", "17:00");
$t->setOpeningHours("2010-12-24", "08:00", "13:00");
$t->setClosed(Business\DaysOfWeek::SUNDAY, Business\DaysOfWeek::WEDNESDAY);
$t->setClosed("2010-12-25");

$a = $t->calculateDeadline(2*60*60, "2010-06-07 09:10");
echo "2*60*60 => 2010-06-07 09:10 <br /> =====> ".$a."<br />";
$a = $t->calculateDeadline(15*60, "2010-06-08 14:48");
echo "15*60 =>  2010-06-08 14:48 <br /> =====> ".$a."<br />";
$a  = $t->calculateDeadline(7*60*60, "2010-12-24 6:45");
echo "7*60*60 => 2010-12-24 6:45 <br /> =====> ".$a."<br />";


//$t->debug();
