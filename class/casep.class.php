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
			return $this->positionX;
		}
		
		function getY(){
			return $this->positionY;
		}
		
		
		function getPion(){
			if($this-> pion == null){
				return  new Pion(null, null, new Joueur(null, 0));
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