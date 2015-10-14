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

		function getPion(){
			if($this-> pion == null){
				return  new Pion(" ", new Joueur("vide"));
			}
			else{
				return $this -> pion;
			}
			
		}
	}


?>