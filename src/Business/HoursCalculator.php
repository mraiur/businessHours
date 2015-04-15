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

        protected function setOpeningHours($date, $startTime, $endTime){
            if( is_int($date) ){

            } else if( $this->isValidDate($date) ){
                call_user_func_array([$this, 'addNonWorkingDays'], func_get_args());
            }
        }

        protected function setClosed(){
            $arguments = func_get_args();
        }


        public function debug(){
            if( func_num_args() > 0 ){
                $args = func_get_args();
                array_walk($args, function( &$v, $key){
                    echo $key." => ".print_r($v, true)."\n";
                });
            } else {
                echo "recurring \n";
                echo "<pre>".print_r($this->recurringOpeningHours, true)."</pre>";
                echo "exceptions \n";
                echo "<pre>".print_r($this->exceptionOpeningHours, true)."</pre>";
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
