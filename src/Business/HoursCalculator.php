<?php
namespace Business{
class HoursCalculator{

        // List of weekdays with opening hours
        private $recurringOpeningHours = [];

        // Date specific opening hours
        private $exceptionOpeningHours = [];

        // Date specific non working days
        private $exceptionNonWorkingDays = [];

        // Non working specific days
        private $nonWorkingDays = [];

        public function __construct($startTime = null, $endTime = null){
            //TODO fill recurring opening hours with the provided $startTime and $endTime as default values
            $daysOfWeekReflection = new \ReflectionClass('Business\DaysOfWeek');
            $daysOfWeek = $daysOfWeekReflection->getConstants();
            foreach($daysOfWeek as $key => $num){
                $this->recurringOpeningHours[$num] = compact('startTime', 'endTime');
            }
        }

        // Validate provided date
        private function isValidDate($date){
            //TODO make more robust date check
            $dateObj = date_parse($date);
            if( $dateObj['year'] > 1970 ){
                return true;
            }
            return false;
        }

        // Add special opening and closing hours for holidays/exceptions
        private function addExceptionOpeningHours($date, $startTime, $endTime){
            $this->exceptionOpeningHours[$date] = compact('startTime', 'endTime');
        }

        private function addExceptionNonWorkingDays($date){
            $this->exceptionNonWorkingDays[] = $date;
        }

        protected function setOpeningHours($date, $startTime, $endTime){
            if( is_int($date) ){
                $this->recurringOpeningHours[$date] = compact('startTime', 'endTime');
            } else if( $this->isValidDate($date) ){
                call_user_func_array([$this, 'addExceptionOpeningHours'], func_get_args());
            }
        }

        private function addClosed($date){
            if( is_int($date) ){
                $this->recurringNonWorkingDays[] = $date;
            } else if( $this->isValidDate($date) ){
                $this->addExceptionNonWorkingDays($date);
            }
        }

        protected function setClosed(){
            $arguments = func_get_args();
            array_walk($arguments, [$this, "addClosed"]);
        }

        private function timeToDate($date){
            if( $this->isValidDate($date) ){
                return date('Y-m-d', strtotime($date) );
            }
            return false;
        }

        private function dayOfTheWeek($date){
            if( $this->isValidDate($date) ){
                return date('N', strtotime($date));
            }
            return false;
        }

        private function isWorkingDay($date){
            if( $this->isValidDate($date) ){
                if( in_array( $this->timeToDate($date), $this->exceptionNonWorkingDays ) ){
                    return false;
                }

                if( in_array( $this->dayOfTheWeek($date), $this->recurringNonWorkingDays )){
                    return false;
                }
            }
            return true;
        }

        private function getWorkingTime($date){
            $workingDay = $date;
            if( !$this->isWorkingDay($date) ){
                // TODO find next working day
                echo "non working day";
            }

            if( isset( $this->exceptionOpeningHours[$this->timeToDate($workingDay)]) ){
                return $this->exceptionOpeningHours[$this->timeToDate($workingDay)];
            }

            if( isset( $this->recurringOpeningHours[$this->dayOfTheWeek($workingDay)]) ){
                return $this->recurringOpeningHours[$this->dayOfTheWeek($workingDay)];
            }
        }

        public function calculateDeadline($businessTime, $submitDate){
            if( is_int($businessTime) && $businessTime > 0 && $this->isValidDate($submitDate) ){
                if( !$this->isWorkingDay($submitDate) ) {
                    return $this->calculateDeadline($businessTime, date("Y-m-d H:i", strtotime($submitDate)+(24*60*60) ));
                }

                $workingTime = $this->getWorkingTime($submitDate);

                if($workingTime){
                    $curStartingDate = $this->timeToDate($submitDate)." ".$workingTime['startTime'];
                    $curEndingDate = $this->timeToDate($submitDate)." ".$workingTime['endTime'];

                    $baseTime = strtotime($submitDate);

                    $diff = ( strtotime($submitDate) - strtotime($curStartingDate) ) / 60;

                    if($diff > 0 ) {
                        // after starting time

                    } else {
                        // before working time
                        $baseTime = strtotime($curStartingDate);
                    }

                    if( $baseTime+$businessTime > strtotime($curEndingDate) ) {
                        return $this->calculateDeadline($businessTime-( strtotime($curEndingDate) - $baseTime ), date("Y-m-d H:i", strtotime($curStartingDate)+(24*60*60) ) );
                    } else {
                        return date('Y-m-d H:i', ($baseTime+$businessTime) );
                    }
                }
            }
        }

        public function debug(){
            if( func_num_args() > 0 ){
                $args = func_get_args();
                array_walk($args, function( &$v, $key){
                    echo $key." => <pre>".print_r($v, true)."</pre><br />\n";
                });
            } else {
                echo "recurring opening hours<br />\n";
                echo "<pre>".print_r($this->recurringOpeningHours, true)."</pre>";
                echo "exceptions opening hours<br />\n";
                echo "<pre>".print_r($this->exceptionOpeningHours, true)."</pre>";

                echo "exceptions closed days<br />\n";
                echo "<pre>".print_r($this->exceptionNonWorkingDays, true)."</pre>";

                echo "recurring closed days<br />\n";
                echo "<pre>".print_r($this->recurringNonWorkingDays, true)."</pre>";


            }
        }


        // Check if protected method exists;
        private function hasMethod($method){
            return method_exists($this, $method);
        }

        // Call protected method if nothing is returned by the method return this.
        public function __call($method, $arguments){
            if( $this->hasMethod($method) ){
                $result = call_user_func_array([$this, $method], $arguments);
                if($result == null){
                    return $result;
                }
            }
            return $this;
        }
    }
}
