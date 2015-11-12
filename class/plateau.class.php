<?php

require_once('casep.class.php');
require_once('pion.class.php');
require_once('joueur.class.php');


  class plateau{

   	private $joueur1;
   	private $joueur2;
   	private $plateau;
	private $tour;
	

	/**
	 *Constructeur de la classe Plateau
	 *@param $j1 : Joueur 1, $j2 : Joueur 2
	 *@return void
	*/
function __construct($j1, $j2){
	$this -> joueur1 = $j1; 
	$this -> joueur2 = $j2;
	$plateau = array();

	//Initilaise l'ensemble des cases du plateau
	for($i=0;$i<5;$i++){ // 5 Lignes / Taille du plateau 5x5
		$y=0;
		if($i==0){
		$ligne = array(new casep($i, $y++, new pion($this->joueur1)));  // Ajoute dans la matrice une case avec ses positions X, Y et un pion. Pion qui dispose d'un joueur ou non.
		$ligne[] = new casep($i, $y++, new pion($this->joueur1));
		$ligne[] = new casep($i, $y++,new pion($this->joueur1));
		$ligne[] = new casep($i, $y++, new pion($this->joueur1));
		$ligne[] = new casep($i, $y++, new pion($this->joueur1));
		}
		if($i==1){
		$ligne = array(new casep($i, $y++, new pion($this->joueur1)));
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, new pion($this->joueur1));
		}
		if($i==2){
		$ligne = array(new casep($i, $y++, null));
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, null);
		}
		if($i==3){
		$ligne = array(new casep($i, $y++, new pion($this->joueur2)));
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, null);
		$ligne[] = new casep($i, $y++, new pion($this->joueur2));
		}
		if($i==4){
		$ligne = array(new casep($i, $y++, new pion($this->joueur2)));
		$ligne[] = new casep($i, $y++, new pion($this->joueur2));
		$ligne[] = new casep($i, $y++,new pion($this->joueur2));
		$ligne[] = new casep($i, $y++, new pion($this->joueur2));
		$ligne[] = new casep($i, $y++, new pion($this->joueur2));
		}

		$this-> plateau[$i] = $ligne;

		
	}
}

	  
	  function setPion($x, $y, $pion){ 
		  $this->plateau[$y][$x]->setPion($pion);
	  }
	  
	  function getPion($x, $y){
		  $p = $this->plateau[$y][$x]->getPion();
		  $this->plateau[$y][$x]->setPion(null);
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
		  return $this->plateau[$y][$x];
	  }
	  
	/**
	 *Fonction qui verifie si un pion est isolée selon la règle du jeu
	 *@param $case : Case 
	 *@return Boolean
	*/
	  function estIsolee($case){
		  //On vérifie que la case dispose bien d'un pion
		  if($case->getPion() == null){
			  return false;
		  }
		  $seul = true;
		  $x = $case->getX();
		  $y = $case->getY();
		  
		  //On regarde pour chaques colonne
		  for($i=0;$i<3;$i++){
			 //Pour chaque lignes
			 for($j=0;$j<3;$j++){
				 //On vérifie que les coordonnées calculées ne sont pas hors du plateau 
				 if($x-1+$i > -1 && $x-1+$i < 5 && $y-1+$j > -1 && $y-1+$j < 5 ){
					//On regarde avec les nouvelles coordonnées les cases alentours : on vérifie si un pion est présent dans ces cases
					if($this->plateau[$y-1+$j][$x-1+$i]->getPion() != null){
						//La case qu'on regarde ne doit pas être la case fournit en paramètres
						if(!($i == 1 && $j == 1)){
							//Si un pion est présent alors la case n'est pas isolé, on revoit faux
							return false;	
						}
					}
				 } 
			 }
		  }
		  //Sinon la case est isolé, on renvoit vrai
		  return true;  
	  }
	  
	/**
	 *Fonction qui vérifie si un pion est seul (Pas isolé mais pas de pion de même couleur autour de lui) selon la règle du jeu
	 *@param $case : Case
	 *@return Boolean
	*/
	  function estSeul($case){
		  //Même principe que la fonction précédente : On regarde autour de la case et on recherche un pion du même joueur que celle qui nous sert de repère
		  if($case->getPion() == null){
			  return false;
		  }
		  $seul = true;
		  $x = $case->getX();
		  $y = $case->getY();
		  
		  for($i=0;$i<3;$i++){
			 for($j=0;$j<3;$j++){
				 
				 if($x-1+$i > -1 && $x-1+$i < 5 && $y-1+$j > -1 && $y-1+$j < 5 ){
					
					if($this->plateau[$y-1+$j][$x-1+$i]->getPion() != null && $this->plateau[$y-1+$j][$x-1+$i]->getPion()->getJoueur() == $this->getJoueurJoue()){
						if(!($i == 1 && $j == 1)){
							return false;	
						}
					}
				 } 
			 }
		  }
		  return true;  
	  }
	  
	/**
	 *Fonction qui retourne l'ensemble des pions isolées d'un joueur
	 *@param $joueur : Joueur
	 *@return $tab : Array
	*/	  
	  function listePionIsole($joueur){
		  $tab[0]=null;
		  $t=0;
		//On parcourt le plateau en Ligne
		for($i=0;$i<5;$i++){
			//On parcourt le plateau en Colonne
			for($j=0;$j<5;$j++){
				if($this->plateau[$i][$j]->getPion() != null && $this->plateau[$i][$j]->getPion()->getJoueur() == $joueur && $this->estIsolee($this->plateau[$i][$j]) == true ){
					$tab[$t++]=$this->plateau[$i][$j];
				}
				
			}	
		}  
		return $tab;
	  }
	  
	/**
	 *Fonction qui retourne l'ensemble des pions Seul d'un joueur
	 *@param $joueur : Joueur
	 *@return $tab : Array
	*/	  
	  function listePionSeul($joueur){
		  $tab[0]=null;
		  $t=0;
		for($i=0;$i<5;$i++){
			for($j=0;$j<5;$j++){
				if($this->plateau[$i][$j]->getPion() != null && $this->plateau[$i][$j]->getPion()->getJoueur() == $this->getJoueurJoue() && $this->estSeul($this->plateau[$i][$j]) == true ){
					$tab[$t++]=$this->plateau[$i][$j];
				}
				
			}	
		}  
		return $tab;
	  }
	  
	  function deplacementPossible($case){
		
		$nb=0;
		$compteur=0;
		$cont=0;
		$x = $case->getX();
		$y = $case->getY();
		
		for($i=0;$i<3;$i++){
			for($j=0;$j<3;$j++){
				$w = $y-1+$j;
				$z = $x-1+$i;
				if($w > -1 && $w < 5 && $z > -1 && $z < 5 && $this->plateau[$w][$z]->getPion() == null ){
					$tab[$nb++]=$this->plateau[$w][$z];
				}				
			}
		}
		
		
		if(isset($tab) == true){
		$taille_tab = count($tab);
		
		for($t=0;$t<$taille_tab;$t++){
		
				
		
		$case_courante=$tab[$t];
		$case_ancien = $case;
		$debut = true;
		
		// echo "X :" . $case_ancien->getX() . "\n";
		// echo "Y :" . $case_ancien->getY(). "\n";
		// echo "Tour : " . $t;
		
		
		
		while($debut){
			
			
		
			$xcase_courante = $case_courante->getX();
			$ycase_courante = $case_courante->getY();
		          
			$difx = $xcase_courante-$case_ancien->getX();
			$dify = $ycase_courante-$case_ancien->getY(); 
			
			
	
		
		if( ($xcase_courante+$difx > -1) && ($xcase_courante+$difx < 5)	&& ($ycase_courante+$dify > -1 ) && ($ycase_courante+$dify < 5) && $this->getCase($xcase_courante+$difx, $ycase_courante+$dify)->getPion() == null){
				$tab[$nb++] = $this->plateau[$ycase_courante+$dify][$xcase_courante+$difx];
				$debut = true;
				$case_ancien = $case_courante;
				$case_courante = $this->plateau[$ycase_courante+$dify][$xcase_courante+$difx];
		}
		
		else{
			$debut = false;
		}
		
		}
		
		}
		
		return $tab;
		}
		else{
			return "vide";
		}
	  }
		
		
  
	  
	  
	  
	  
	  function caseExiste($tab, $case){
		  if($tab[0] == null){
			  return false;
		  }
		  for($i=0;$i<count($tab);$i++){
			  if($tab[$i] == $case){
				 return true;
			  }
		  }
		  return false;
	  }
	  
	 
	function CompareTab($tab_isole, $tab2){
		$nb = 0;
		for($i=0;$i<count($tab2);$i++){
			for($j=0;$j<count($tab_isole);$j++){
				if($tab_isole[$j] == $tab2[$i]){
					$tab3[$nb++] = $tab_isole[$j];
				}
			}
		}
		return $tab3;
	}
	
	function casePionIsole($case){
		
		$nb=0;
		$compteur=0;
		$cont=0;
		$x = $case->getX();
		$y = $case->getY();
		
		for($i=0;$i<3;$i++){
			for($j=0;$j<3;$j++){
				$w = $y-1+$j;
				$z = $x-1+$i;
				if($w > -1 && $w < 5 && $z > -1 && $z < 5 && $this->plateau[$w][$z]->getPion() == null ){
					$tab[$nb++]=$this->plateau[$w][$z];
				}				
			}
		}
		return $tab;
	}
	
	
	
	
	
	
	  

function affichage(){
	
	//Un piont est isolé ?
	if($this->listePionIsole($this->getJoueurJoue())[0] == null){
		$poinisole = false;
	}
	else{
		$pionisole = true;
	}

	$plateauhtml ="<meta http-equiv=content-type content=text/html; charset=utf-8 /> <link rel=stylesheet type=text/css href=style.css> <body> <div class=login> <div class=login-screen> <div class=app-title> <table border="."10px"." align=center>";
	
	for($i=0;$i<5;$i++){
		$y=0;
		$plateauhtml = $plateauhtml . "\n <tr>";
			for($x=0;$x<5;$x++){
				if( isset($_GET['var1'])==false || isset($_GET['var1'])==true && isset($_GET['var2'])==true){
					
					if($this->plateau[$i][$x]->getPion() == null){
						$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px".">" . "</td>";
					}
										
					else if($this->plateau[$i][$x]-> getPion()-> getJoueur() == $this->getJoueurJoue()){
						
						
						$tab2 = $this->listePionSeul($this->getJoueurJoue());
						
						if($tab2[0] != null && $this->caseExiste($tab2, $this->plateau[$i][$x]) == true ){
							$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px><div class=cercle2 style=background:".$this->plateau[$i][$x]->getPion()->getJoueur()->getCouleur().">".$this->plateau[$i][$x]->getPion()->getJoueur()->getIni()."</div>" . "</td>";	
						}
						
						else if($this->deplacementPossible($this->plateau[$i][$x]) == "vide"){
						$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px><div class=cercle2 style=background:".$this->plateau[$i][$x]->getPion()->getJoueur()->getCouleur().">".$this->plateau[$i][$x]->getPion()->getJoueur()->getIni()."</div>" . "</td>";	
						}
						else{
						$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px"."><a href="."?var1=".$x.$i.">" ."<div class=cercle style=background:".$this->plateau[$i][$x]->getPion()->getJoueur()->getCouleur().">".$this->plateau[$i][$x]->getPion()->getJoueur()->getIni()."</div></a>" . "</td>";
						}
					}
							
					else if($this->plateau[$i][$x]-> getPion()->getJoueur() == $this->getJoueurNonJoue()){
						$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px"."> <div class=cercle2 style=background:".$this->plateau[$i][$x]->getPion()->getJoueur()->getCouleur().">".$this->plateau[$i][$x]->getPion()->getJoueur()->getIni()."</div> </a>" . "</td>";	
					}
					else {
						$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px> </td>";
					}
				}
		}
	}

	$plateauhtml = $plateauhtml . "</body></table> <br> <p>A ".$this->getJoueurJoue()->getPseudo()." de jouer !<p><br> ";
	$plateauhtml = $plateauhtml . "<a href=?retour><input type=submit class=btn btn-primary btn-large btn-block value=Annuler /> </a><br>";
	$plateauhtml = $plateauhtml . "<form  action=\"entropie.php\" method=\"post\"><input class=btn btn-primary btn-large btn-block name=\"click\" type=\"submit\" value=\"Reinitialiser\"></form> </div> </div> </div>";


	return $plateauhtml;
	


}


  function affichage2(){
	  
	 $plateauhtml = "<meta http-equiv=content-type content=text/html; charset=utf-8 /> <link rel=stylesheet type=text/css href=style.css> <body> <div class=login> <div class=login-screen> <div class=app-title> <table align=center>";
	
	for($z=0;$z<5;$z++){
	
		$plateauhtml = $plateauhtml . "\n <tr>";
			for($x=0;$x<5;$x++){
				
				if( isset($_GET['var1']) == true && isset($_GET['var2']) == false ){
				
					if($this->plateau[$z][$x]-> getPion() == null){
						$m = substr($_GET['var1'], 0, 1);
						$n= substr($_GET['var1'], 1);
						
						$tab = $this->deplacementPossible($this->getCase($m, $n));
						if(!empty($tab) && $this->caseExiste($tab, $this->getCase($x, $z))){
						$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px"."> <a href="."?var1=".$_GET['var1'] ."&var2=". $x.$z ." >  <div class=cercle2 style=background:".$this->getJoueurJoue()->getCouleur().">".$this->getJoueurJoue()->getIni()."</div></img> </a>" . "</td>";
						}
						else{
						$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px".">" . "</td>";	
						}
					}
					else if($this->plateau[$z][$x]-> getPion()->getJoueur() == $this->getJoueurJoue()){
						$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px"."> <div class=cercle style=background:".$this->plateau[$z][$x]->getPion()->getJoueur()->getCouleur().">".$this->plateau[$z][$x]->getPion()->getJoueur()->getIni()."</div>" . "</td>";	
					}
					else if($this->plateau[$z][$x]-> getPion()->getJoueur() == $this->getJoueurNonJoue()){
						$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px"."> <div class=cercle style=background:".$this->plateau[$z][$x]->getPion()->getJoueur()->getCouleur().">".$this->plateau[$z][$x]->getPion()->getJoueur()->getIni()."</div>" . "</td>";	
					}
					else {
						$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px>" . $this-> plateau[$z][$x]-> getPion()-> getCouleur() . "</td>";
					}
				}
			}
	}

	
		$plateauhtml = $plateauhtml . "\n </tr> </table><br> <p>Déplace ton pion ".$this->getJoueurJoue()->getPseudo()." !</><br> <br>";
		$plateauhtml = $plateauhtml . "<a href=entropie.php><input type=submit class=btn btn-primary btn-large btn-block value=Annuler /> </a> <br>";
		$plateauhtml = $plateauhtml . "<form  action=\"entropie.php\" method=\"post\"><input class=btn btn-primary btn-large btn-block name=\"click\" type=\"submit\" value=\"Reinitialiser\"></form> </div> </div> </div>";

			
		
	return $plateauhtml;

}
  
	  
  } 


?>