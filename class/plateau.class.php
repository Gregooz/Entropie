<?php

require_once('casep.class.php');
require_once('pion.class.php');
require_once('joueur.class.php');


  class plateau{

   	private $joueur1;
   	private $joueur2;
   	private $plateau;
	private $tour;
	


function __construct($j1, $j2){
	$this -> joueur1 = $j1;
	$this -> joueur2 = $j2;
	$this -> tour = 0;
	$plateau = array();

	
	for($i=0;$i<5;$i++){
		$y=0;
		if($i==0){
		$ligne = array(new casep($i, $y, new pion("Jaune", $this->joueur1)));
		$ligne[] = new casep($i, $y++, new pion("Jaune", $this->joueur1));
		$ligne[] = new casep($i, $y++,new pion("Jaune", $this->joueur1));
		$ligne[] = new casep($i, $y++, new pion("Jaune", $this->joueur1));
		$ligne[] = new casep($i, $y++, new pion("Jaune", $this->joueur1));
		}
		if($i==1){
		$ligne = array(new casep($i, $y, new pion("Jaune", $this->joueur1)));
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, new pion("Jaune", $this->joueur1));
		}
		if($i==2){
		$ligne = array(new casep($i, $y, null));
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, null);
		}
		if($i==3){
		$ligne = array(new casep($i, $y, new pion("Rouge", $this->joueur2)));
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, new pion("Rouge", $this->joueur2));
		}
		if($i==4){
		$ligne = array(new casep($i, $y, new pion("Rouge", $this->joueur2)));
		$ligne[] = new casep($i, $y++, new pion("Rouge", $this->joueur2));
		$ligne[] = new casep($i, $y++,new pion("Rouge", $this->joueur2));
		$ligne[] = new casep($i, $y++, new pion("Rouge", $this->joueur2));
		$ligne[] = new casep($i, $y++, new pion("Rouge", $this->joueur2));
		}

		$this-> plateau[$i] = $ligne;

		
	}
}

	  
	  function setPion($x, $y, $pion){ 
		  $this->plateau[$x][$y]->setPion($pion);
	  }
	  
	  function getPion($x, $y){
		  $p = $this->plateau[$x][$y]->getPion();
		  $this->plateau[$x][$y]->setPion(new Pion(null, null, new Joueur(null, 0)));
		  return $p;
	  }
	  
	  function getTour(){
		  return $this -> tour;
	  }
	  
	  function estGagne(){
		  return false;
	  }
	  
	  function getJoueur1(){
		  return $this->joueur1;
	  }
	  
	  function getJoueur2(){
		  return $this->joueur2;
	  }
	  
	  function toursuivant(){
		  if($this->joueur1->getJoue() == true){
			  $this->joueur1->setJoue(false);
			  $this->joueur2->setJoue(true);
		  }
		  else{
			  $this->joueur1->setJoue(true);
			  $this->joueur2->setJoue(false);
		  }
	  }
	  
	  function getJoueurJoue(){
		  if($this->joueur1->getJoue() == true){
			  return $this->joueur1;
		  }
		  else{
			  return $this->joueur2;
		  }
	  }
	  
	  function getJoueurNonJoue(){
		  if($this->joueur1->getJoue() == false){
			  return $this->joueur1;
		  }
		  else{
			  return $this->joueur2;
		  }
	  }
	  
	  function getCase($x, $y){
		  if($x < 0 || $y < 0 || $x > 4 || $y > 4){
			  throw new Exception('Erreur GetCase');
		  }
		  else{
		  return $this->plateau[$x][$y];
		  }
	  }
	  
	  function estIsolee($case){
		  $seul = "oui";
		for($i=0;$i<3;$i++){
			for($j=0;$j<3;$j++){
				try{
					if($seul = "oui"){
					if(($this->getCase($case->getX()-1+$i, $case->getY()-1+$j)->getPion()->getJoueur() == $this->getJoueur1() || $this->getCase($case->getX()-1+$i, $case->getY()-1+$j)->getPion()->getJoueur() == $this->getJoueur2())  && ($i!=1 && $j!=1) ){
						$seul = "non";
					}
					}
				} catch(Exception $e){
					echo $e;
				}
			}
		}
		return $seul;
	  }
	  
	  function listePionIsole($joueur){
		  $tab;
		  $t=0;
		for($i=0;$i<5;$i++){
			for($j=0;$j<5;$j++){
				if($this->plateau[$i][$j]->getPion()->getJoueur() == $this->getJoueurJoue() && $this->estIsolee($this->plateau[$i][$j]) == true ){
					$tab[$t++]=$this->plateau[$i][$j];
				}
				
			}	
		}  
		return $tab;
	  }	  

function affichage(){

	$plateauhtml = "<table border=\"1px\" >";
	
	for($i=0;$i<5;$i++){
		$y=0;
		$plateauhtml = $plateauhtml . "\n <tr>";
			for($x=0;$x<5;$x++){
				if( isset($_GET['var1'])==false || isset($_GET['var1'])==true && isset($_GET['var2'])==true){
					if($this->plateau[$i][$x]-> getPion()-> getJoueur() == $this->getJoueurJoue()){
						$plateauhtml = $plateauhtml . "\n <td width=\"100px\" height=\"100px\"align=\"center\"> <a href=?var1=".$i.$x."><img src=".$this->getJoueurJoue()->getNum(). ".jpg height=\"90px\" width=\"90px\"> </a></td>";
					}
					else if($this->plateau[$i][$x]-> getPion()->getJoueur() == $this->getJoueurNonJoue()){
						$plateauhtml = $plateauhtml . "\n <td width=\"100px\" height=\"100px\"align=\"center\"> <img src=".$this->getJoueurNonJoue()->getNum(). ".jpg height=\"70px\" width=\"70px\"> </a></td>";	
					}
					else {
						$plateauhtml = $plateauhtml . "\n <td width=\"100px\" height=\"100px\"align=\"center\"></td>";
					}
				}
		}
	}

	$plateauhtml = $plateauhtml . "</table>";
	$plateauhtml = $plateauhtml . "<form  action=\"entropie.php\" method=\"post\"><input name=\"click\" type=\"submit\" value=\"Reinitialiser\"></form>";

	return $plateauhtml;
	


}


  function affichage2(){
	  
	  $plateauhtml = "<table border=\"1px\">";

	for($z=0;$z<5;$z++){
	
		$plateauhtml = $plateauhtml . "\n <tr>";
			for($x=0;$x<5;$x++){
				
				if( isset($_GET['var1']) == true && isset($_GET['var2']) == false ){
				
					if($this->plateau[$z][$x]-> getPion()->getJoueur()==null && $this->getJoueurJoue() == $this->joueur1){
						$plateauhtml = $plateauhtml . "\n <td width=\"100px\" height=\"100px\"align=\"center\"> <a href= ?var1=".$_GET['var1'] ."&var2=". $z.$x ."><img src=1_libre.jpg height=\"90px\" width=\"90px\"></a></td>";
					}
					else if($this->plateau[$z][$x]-> getPion()->getJoueur()==null && $this->getJoueurJoue() == $this->joueur2){
						$plateauhtml = $plateauhtml . "\n <td width=\"100px\" height=\"100px\"align=\"center\"> <a href= ?var1=".$_GET['var1'] ."&var2=". $z.$x ."><img src=2_libre.jpg height=\"90px\" width=\"90px\"></a></td>";
					}
					else if($this->plateau[$z][$x]-> getPion()->getJoueur() == $this->joueur2){
						$plateauhtml = $plateauhtml . "\n <td width=\"100px\" height=\"100px\" align=\"center\"> <img src=2.jpg height=\"90px\" width=\"90px\"></td>";	
					}
					else if($this->plateau[$z][$x]-> getPion()->getJoueur() == $this->joueur1){
						$plateauhtml = $plateauhtml . "\n <td width=\"100px\" height=\"100px\"align=\"center\"> <img src=1.jpg height=\"90px\" width=\"90px\"></td>";	
					}
					else {
						$plateauhtml = $plateauhtml . "\n <td width=\"100px\" height=\"100px\"align=\"center\">" . $this-> plateau[$z][$x]-> getPion()-> getCouleur() . "</td>";
					}
				}
			}
	}

	
		$plateauhtml = $plateauhtml . "\n </tr>";
			
		
	return $plateauhtml;

}
  
	  
  } 


?>