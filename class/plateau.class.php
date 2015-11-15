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

	/**
	 *Passe au tour suivant : Modifie le joueur qui joue
	 *@param void
	 *@return void
	*/
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
	  
	/**
	 *Fonction qui retourne le joueur qui joue actuellement
	 *@param void
	 *@return Joueur
	*/
	  function getJoueurJoue(){
		  if($this->joueur1->getJoue() == true){
			  return $this->joueur1;
		  }
		  else{
			  return $this->joueur2;
		  }
	  }
	  
	/**
	 *Fonction qui retourne je joueur qui ne joue pas
	 *@param void
	 *@return Joueur
	*/
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
	  
	/**
	 *Fonction que retourne la liste des position ou un pion donne peut aller 
	 *@param $case : Case
	 *@return $tab : Array
	*/
	  function deplacementPossible($case){
		
		$nb=0;
		$x = $case->getX();
		$y = $case->getY();
		
		//On recupère les cases autour du pion que l'on souhaite déplacer
		//On regarde les lignes
		for($i=0;$i<3;$i++){
			//On regarde les colonnes
			for($j=0;$j<3;$j++){
				$w = $y-1+$j;
				$z = $x-1+$i;
				//On verifie que les coordonnées ne se trouve pas à l'extérieur du plateau et que la position calculé est libre
				if($w > -1 && $w < 5 && $z > -1 && $z < 5 && $this->plateau[$w][$z]->getPion() == null ){
					//On ajoute cette case au tableau
					$tab[$nb++]=$this->plateau[$w][$z];
				}				
			}
		}
		
		
		if(isset($tab) == true){
			//On regarde combien on a de case dans notre tableau
			$taille_tab = count($tab);
		
		for($t=0;$t<$taille_tab;$t++){
				//Pour chaque case récupéré précédement...
				
		$case_courante=$tab[$t];
		$case_ancien = $case;
		$debut = true;
		
		//Tant qu'on trouve des cases accessible dans une direction 
		while($debut){

			$xcase_courante = $case_courante->getX();
			$ycase_courante = $case_courante->getY();
		     
			//On calcul les diférence entre la case courante et la case précédente
			$difx = $xcase_courante-$case_ancien->getX();
			$dify = $ycase_courante-$case_ancien->getY(); 
			
			
	
		//On verfie qu'on ne sort pas du plateau et que la case calculé est libre
		if( ($xcase_courante+$difx > -1) && ($xcase_courante+$difx < 5)	&& ($ycase_courante+$dify > -1 ) && ($ycase_courante+$dify < 5) && $this->getCase($xcase_courante+$difx, $ycase_courante+$dify)->getPion() == null){
				//On ajoute la case au tableau de case accessible
				$tab[$nb++] = $this->plateau[$ycase_courante+$dify][$xcase_courante+$difx];
				$debut = true;
				//On modifie la case courante et la case précédente
				$case_ancien = $case_courante;
				$case_courante = $this->plateau[$ycase_courante+$dify][$xcase_courante+$difx];
		}
		
		//Sinon on arrête de calculer les coordonnées dans ce sens
		else{
			$debut = false;
		}
		
		}
		
		}
		
		//On retourne le tableau de cases accessible par le pion
		return $tab;
		}
		else{
			return "vide";
		}
	  }
		
		
	/**
	 *Fonction qui détermine si une case donnée est présente dans un tableau de cases donné
	 *@param $tab : Array, $case : Case
	 *@return Boolean
	*/
	  function caseExiste($tab, $case){
		  //Si le tableau est null alors pas de correspondance
		  if($tab[0] == null){
			  return false;
		  }
		  //Autrement on parcourt le tableau 1 à 1 et on compare avec la case donnée
		  for($i=0;$i<count($tab);$i++){
			  //Si correspondance alors on retourne vrai
			  if($tab[$i] == $case){
				 return true;
			  }
		  }
		  return false;
	  }
	  
	/**
	 *Fonction qui compare deux tableaux qui retourne un troisième tableau contenant les cases communes aux deux premier tableaux
	 *@param $tab_isolé : Array, $tab2 : Array
	 *@return $tab3 : Array
	*/	 
	function CompareTab($tab_isole, $tab2){
		$nb = 0;
		$tab3[0] = null;
		//On parcourt le premier tableau
		for($i=0;$i<count($tab2);$i++){
			//On parcours tout le 2è tableau pour chaque case du premier tableau
			for($j=0;$j<count($tab_isole);$j++){
				//On compare les deux tableaux, si les case correspondent on les stocke dans un tableau
				if($tab_isole[$j] == $tab2[$i]){
					$tab3[$nb++] = $tab_isole[$j];
				}
			}
		}
		return $tab3;
	}
	
	/**
	 *Fonction qui retourne l'ensembles des cases autour d'une case donnée
	 *@param $case : Casep
	 *@return $tab : Array
	*/	 	
	function caseAutourCase($case){
		$nb=0;
		$x = $case->getX();
		$y = $case->getY();
		$tab[0] = null;
		
		//On recupère les cases autour du pion que l'on souhaite déplacer
		//On regarde les lignes
		for($i=0;$i<3;$i++){
			//On regarde les colonnes
			for($j=0;$j<3;$j++){
				$w = $y-1+$j;
				$z = $x-1+$i;
				//On verifie que les coordonnées ne se trouve pas à l'extérieur du plateau et que la position calculé est libre
				if($w > -1 && $w < 5 && $z > -1 && $z < 5 && $this->plateau[$w][$z]->getPion() == null ){
					//On ajoute cette case au tableau
					$tab[$nb++]=$this->plateau[$w][$z];
				}				
			}
		}
		return $tab;
	}
	

	  
	/**
	 *Fonction qui permet d'afficher le plateau à l'état ou l'utilisateur doit chosir le pion a déplacer
	 *@param void
	 *@return $plateauhtml : String
	*/	 
	function affichage(){
	
	

	$plateauhtml ="<meta http-equiv=content-type content=text/html; charset=utf-8 /> <link rel=stylesheet type=text/css href=style.css> <body> <div class=login> <div class=login-screen> <div class=app-title> <table border="."10px"." align=center>";

	$affmessage = false;
	
	//On parcourt le plateau colonne par colonne
	for($i=0;$i<5;$i++){
		$y=0;
		$plateauhtml = $plateauhtml . "\n <tr>";
			//Puis parcourt ligne par ligne
			for($x=0;$x<5;$x++){
				if( isset($_GET['var1'])==false || isset($_GET['var1'])==true && isset($_GET['var2'])==true){
					
					//Si la case ne comporte pas de pion, on affiche une case vide
					if($this->plateau[$i][$x]->getPion() == null){
						$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px".">" . "</td>";
					}
					
					//Si la case contient un pion qui appartient au joueur qui joue
					else if($this->plateau[$i][$x]-> getPion()-> getJoueur() == $this->getJoueurJoue()){
						
						//On récupère la liste des Pions seul
						$tab2 = $this->listePionSeul($this->getJoueurJoue());
						//On récupère la liste des pions isolées
						$tab3 = $this->listePionIsole($this->getJoueurJoue());
									
						//Si il existe des pions seul ET que la case courante du plateau se trouve dans la liste des pions seul
						if($tab2[0] != null && $this->caseExiste($tab2, $this->plateau[$i][$x]) == true ){
							//On affiche une case contenant le pion mais ce pion ne peut rien faire (pas de lien)
							$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px><div class=cercle2 style=background:".$this->plateau[$i][$x]->getPion()->getJoueur()->getCouleur().">".$this->plateau[$i][$x]->getPion()->getJoueur()->getIni()."</div>" . "</td>";	
						}
						
						//Si il existe des pion isolée
						else if($tab3[0] != null){
							//Si la liste des déplacements possibles du pion de la case courante du plateau sont en parti commun avec un des pions isolées 
							if($this->CompareTab($this->caseAutourCase($tab3[0]), $this->deplacementPossible($this->plateau[$i][$x]))[0] != null){
							$affmessage = true;
							//Alors, on affiche une case avec le pion du joueur et avec un lien. On pourra sélectionnner ce pion
							$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px"."><a href="."?var1=".$x.$i.">" ."<div class=cercle style=background:".$this->plateau[$i][$x]->getPion()->getJoueur()->getCouleur().">".$this->plateau[$i][$x]->getPion()->getJoueur()->getIni()."</div></a>" . "</td>";
							}
							//Sinon on affiche le pion sans lien
							else{
							$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px"."><div class=cercle2 style=background:".$this->plateau[$i][$x]->getPion()->getJoueur()->getCouleur().">".$this->plateau[$i][$x]->getPion()->getJoueur()->getIni()."</div></a>" . "</td>";
							}
						}
						//Si le pion de la case courante ne peut faire aucun déplacement 
						else if($this->deplacementPossible($this->plateau[$i][$x]) == "vide"){
						//Alors impossible de la sélectionner
						$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px><div class=cercle2 style=background:".$this->plateau[$i][$x]->getPion()->getJoueur()->getCouleur().">".$this->plateau[$i][$x]->getPion()->getJoueur()->getIni()."</div>" . "</td>";	
						}
						//Sinon on peut déplacer le pion
						else{
						$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px"."><a href="."?var1=".$x.$i.">" ."<div class=cercle style=background:".$this->plateau[$i][$x]->getPion()->getJoueur()->getCouleur().">".$this->plateau[$i][$x]->getPion()->getJoueur()->getIni()."</div></a>" . "</td>";
						}
					}
					//Si le pion appartient au joueur qui ne joue pas alors on affiche juste son pion		
					else if($this->plateau[$i][$x]-> getPion()->getJoueur() == $this->getJoueurNonJoue()){
						$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px"."> <div class=cercle2 style=background:".$this->plateau[$i][$x]->getPion()->getJoueur()->getCouleur().">".$this->plateau[$i][$x]->getPion()->getJoueur()->getIni()."</div> </a>" . "</td>";	
					}
					//Sinon on affiche une case vide (sécurité) 
					else {
						$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px> </td>";
					}
				}
		}
	}
	if($affmessage == true){
		$message ="<br>Vous devez reconnecter un pion !";
	}
	else{
		$message=" ";
	}
	$plateauhtml = $plateauhtml . "</body></table> <br> <p>A ".$this->getJoueurJoue()->getPseudo()." de jouer !".$message."<p><br> ";
	//Ajout du bouton pour annuler le dernier déplacement
	$plateauhtml = $plateauhtml . "<a href=?retour><input type=submit class=btn btn-primary btn-large btn-block value=Annuler /> </a><br>";
	//Ajout du bouton pour réinitialiser la partie
	$plateauhtml = $plateauhtml . "<form  action=\"entropie.php\" method=\"post\"><input class=btn btn-primary btn-large btn-block name=\"click\" type=\"submit\" value=\"Reinitialiser\"></form> </div> </div> </div>";


	return $plateauhtml;
	


}

	/**
	 *Fonction qui affiche le plateau à l'état ou l'utilisateur doit choisir le déplacement qui veut réaliser
	 *@param void
	 *@return $plateauhtml : String
	*/	 
  function affichage2(){
	  
	 $plateauhtml = "<meta http-equiv=content-type content=text/html; charset=utf-8 /> <link rel=stylesheet type=text/css href=style.css> <body> <div class=login> <div class=login-screen> <div class=app-title> <table align=center>";
	
	//On parcourt le plateau de colonne en colonne
	for($z=0;$z<5;$z++){
	
		$plateauhtml = $plateauhtml . "\n <tr>";
			//On parcourt le plateau de ligne en ligne
			for($x=0;$x<5;$x++){
				
				//Si on à sélectionné un pion mais pas le deuxième
				if( isset($_GET['var1']) == true && isset($_GET['var2']) == false ){
					
					//On récupère les positions du pion sélectionné
					$m = substr($_GET['var1'], 0, 1);
					$n= substr($_GET['var1'], 1);
				
					//Si la case courante du plateau ne contient pas de pions
					if($this->plateau[$z][$x]-> getPion() == null){
						
						//On récupère l'ensembles de positions ou peut aller le pion sélctionné
						$tab = $this->deplacementPossible($this->getCase($m, $n));
						//On récupère la liste des pions isolées
						$tab3 = $this->listePionIsole($this->getJoueurJoue());
						
						//Si il existe des pions isolées
						if($tab3[0] != null){
							//Si le pion sélectionner a des déplacements commun avec les case autour du pions isolé 
							$tab4 = $this->CompareTab($this->caseAutourCase($tab3[0]), $this->deplacementPossible($this->getCase($m, $n)));
							if($this->caseExiste($tab4, $this->plateau[$z][$x])){
								//Alors on afficher comme déplacement possible cette case
								$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px"."> <a href="."?var1=".$_GET['var1'] ."&var2=". $x.$z ." >  <div class=cercle2 style=background:".$this->getJoueurJoue()->getCouleur().">".$this->getJoueurJoue()->getIni()."</div></img> </a>" . "</td>";
							}
							else if($this->plateau[$z][$x]->getPion() == null){
								$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px".">" . "</td>";	
							}
							else if($this->plateau[$z][$x]-> getPion()->getJoueur() == $this->getJoueurJoue()){
								$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px"."> <div class=cercle style=background:".$this->plateau[$z][$x]->getPion()->getJoueur()->getCouleur().">".$this->plateau[$z][$x]->getPion()->getJoueur()->getIni()."</div>" . "</td>";	
							}
							else if($this->plateau[$z][$x]-> getPion()->getJoueur() == $this->getJoueurNonJoue()){
								$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px"."> <div class=cercle2 style=background:".$this->plateau[$z][$x]->getPion()->getJoueur()->getCouleur().">".$this->plateau[$z][$x]->getPion()->getJoueur()->getIni()."</div>" . "</td>";	
							}
						else{
							$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px>" . $this-> plateau[$z][$x]-> getPion()-> getCouleur() . "</td>";
							}
						}
						
						//Autrement si la pion peut se déplacer
						else if(!empty($tab) && $this->caseExiste($tab, $this->getCase($x, $z))){
						//Pion de déplacement cliquable
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
						$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px"."> <div class=cercle2 style=background:".$this->plateau[$z][$x]->getPion()->getJoueur()->getCouleur().">".$this->plateau[$z][$x]->getPion()->getJoueur()->getIni()."</div>" . "</td>";	
					}
					//Sinon on affiche la case (sécurité)
					else {
						$plateauhtml = $plateauhtml . "\n <td width="."100px height="."100px></td>";
					}

				}
			}
	}

	
		$plateauhtml = $plateauhtml . "\n </tr> </table><br> <p>Déplace ton pion ".$this->getJoueurJoue()->getPseudo()." !</><br> <br>";
		//Ajout du bouton pour effectuer le retour en arrière
		$plateauhtml = $plateauhtml . "<a href=entropie.php><input type=submit class=btn btn-primary btn-large btn-block value=Annuler /> </a> <br>";
		//Ajout du bouton pour réinitialiser la partie
		$plateauhtml = $plateauhtml . "<form  action=\"entropie.php\" method=\"post\"><input class=btn btn-primary btn-large btn-block name=\"click\" type=\"submit\" value=\"Reinitialiser\"></form> </div> </div> </div>";

			
		
	return $plateauhtml;

}
  
	  
  } 


?>