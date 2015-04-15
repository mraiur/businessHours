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
            }
            if( in_array( $this->timeToDate($date), $this->exceptionOpeningHours ) ){
                return $this->exceptionOpeningHours[$this->timeToDate($date)];
            }

            if( in_array( $this->daysOfTheWeek($date), $this->recurringOpeningHours) ){
                return $this->recurringOpeningHours[$this->daysOfTheWeek($date)];
            }
        }

        public function calculateDeadline($businessTime, $submitDate){
            if( is_int($businessTime) && $businessTime > 0 && $this->isValidDate($submitDate) ){

            }
        }

        public function debug(){
            if( func_num_args() > 0 ){
                $args = func_get_args();
                array_walk($args, function( &$v, $key){
                    echo $key." => ".print_r($v, true)."\n";
                });
            } else {
                echo "recurring opening hours\n";
                echo "<pre>".print_r($this->recurringOpeningHours, true)."</pre>";
                echo "exceptions opening hours\n";
                echo "<pre>".print_r($this->exceptionOpeningHours, true)."</pre>";

                echo "exceptions closed days\n";
                echo "<pre>".print_r($this->exceptionNonWorkingDays, true)."</pre>";

                echo "recurring closed days\n";
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
