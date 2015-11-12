<?php

	class casep{

		private $positionX;
		private $positionY;
		private $pion;
		
		
		function __construct($X, $Y, $pi){
			$this -> positionX = $X;
			$this -> positionY = $Y;
			$this -> pion = $pi;
		}		
		
		function getX(){
			return $this->positionY;
		}
		
		function getY(){
			return $this->positionX;
		}
		
		
		function getPion(){
			if($this-> pion == null){
				return 0;
			}
			else{
				return $this -> pion;
			}
			
		}
		
		function setPion($pion){
			$this->pion = $pion;
		}
	}


?>