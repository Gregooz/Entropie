<?php

require_once('casep.class.php');
require_once('pion.class.php');


  class plateau{

   	private $joueur1;
   	private $joueur2;
   	private $plateau;


function __construct($j1, $j2){
	$this -> joueur1 = $j1;
	$this -> joueur2 = $j2;
	$plateau = array();

	for($i=0;$i<5;$i++){
		$y=0;
		$ligne = array(new casep($i, $y, new pion("Jaune", $this->joueur1)));
		$ligne[] = new casep($i, $y++, new pion("Jaune", $this->joueur1));
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, new pion("Rouge", $this->joueur2));

		$this-> plateau[$i] = $ligne;

		
	}
}


function affichage(){

	$plateauhtml = "<table border="."1px".">";

	for($i=0;$i<5;$i++){
		$y=0;
		$plateauhtml = $plateauhtml . "\n <tr>";
		$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px".">" . $this-> plateau[$i][$y++]-> getPion()-> getCouleur() . "</td>";
		$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px".">" . $this-> plateau[$i][$y++]->getPion()->getCouleur() . "</td>";
		$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px".">" . $this-> plateau[$i][$y++]->getPion()->getCouleur() . "</td>";
		$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px".">" . $this-> plateau[$i][$y++]->getPion()->getCouleur() . "</td>";
		$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px".">" . $this-> plateau[$i][$y++]->getPion()->getCouleur() . "</td>";
		$plateauhtml = $plateauhtml . "\n </tr>";
	}

	$plateauhtml = $plateauhtml . "</table>";

	return $plateauhtml;

}








}