<?php
    class Test {
		//muutujad ehk omadused (properties)
	    private $unknown_number = 5;
	    public $known_number = 4;
		private $sent_number;
		
		//funktsioonid ehk meetodid
		function __construct($received_number){
			echo " Klass alustas! ";
		    $this->sent_number = $received_number;
			$this->multiply();
		}
		
		private function multiply(){
			echo "Salajaste arvude korrutis on :" .$this->unknown_number * $this->sent_number;
		}
		
		public function reveal(){
			echo " Salajased arvud on: " .$this->unknown_number " ja " $this->sent_number;
		}
		
	
	}



?>