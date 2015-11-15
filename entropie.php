<?php
session_start();


require_once('class/joueur.class.php');
require_once('class/plateau.class.php');


//Demande de Réinitialisation de la partie :
//On supprime les Seesions : Le plateau
if(isset($_POST["click"])){
	unset($_SESSION['plateau']);
	unset($_SESSION['ancien_plateau']);
}


//Si pas de session et pas de Joueur fourni est Post
//Alors on affiche une page HTML qui permets a l'utilisateur d'entré les informations
//nécéssaires pour créer une partie.
if(!isset($_SESSION['plateau']) && !isset($_POST['joueur1']) && !isset($_POST['joueur2'])){
	
	
// Page HTML : Comprend un formulaire en POST. Envoie les informations a la page elle-même
	?>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />	
<link rel="stylesheet" type="text/css" href="style.css"> 
<title>Entropie </title>


    
	
	<div class="login">
		<div class="login-screen">
			<div class="app-title">
				<h1 style="font-size:60px">Entropie</h1>
			</div>
			<form method="post" action="">
			<div class="login-form">
				<div class="control-group">
				<input type="text" class="imput" placeholder="Ex : Noé" name="joueur1" id="login-name"/>
				<input  type="color" class="couleur" name="couleur1" value="#EFDF06"/>
				</div>
				<br><br>
				<div class="control-group">
				<input type="text" class="imput" placeholder="Ex : Grégoire" name="joueur2" id="login-pass"/>
				<input  type="color" class="couleur" name="couleur2" value="#BF00FF"/>
				</div>
	<br><br>
				<input type="submit" class="btn btn-primary btn-large btn-block" value="Commencer"/>
			</div>
			</form>
			<div class="real">Réalisé par Noé Le Carduner & Grégoire Decamp avec <a href="https://github.com/Gregooz/Entropie">Github.com</a></div>
		</div>
	</div>
	<?php
	//Fin de page HTML
}

// Si il n'y a pas de SESSION mais qu'on nous a fournit des informations avec le Post
//Alors je créer un nouveau plateau (partie) puis le stock en SESSION

else if(!isset($_SESSION['plateau']) && isset($_POST['joueur1']) && isset($_POST['joueur2'])){
$j1 = new joueur($_POST['joueur1'], 1, $_POST['couleur1']);
$j2 = new joueur($_POST['joueur2'], 2, $_POST['couleur2']);
$j1->setJoue(true);
$p = new plateau($j1, $j2);
$_SESSION['plateau'] = serialize($p);
$_SESSION['ancien_plateau'] = serialize($p);
}

//Sinon j'ai un plateau : Je n'est qu'a le récupérer
else{
	$p = unserialize($_SESSION['plateau']);
}


//Si je dispose d'un plateau en SESSION...
if(isset($_SESSION['plateau'])){


//Si 'retour' est fournit en GET grace aux URL longues,
//Je récupère l'ancien plateau dans les sessions	
if(isset($_GET['retour'])){
	$_SESSION['plateau'] = $_SESSION['ancien_plateau'];
	$p = unserialize($_SESSION['plateau']);
	$p->affichage();
}
	
	
//Si on dispose de la position du pion a déplacer ainsi que l'endroit ou le déplacer grace aux URL longues
if(isset($_GET['var1'])==true && isset($_GET['var2'])==true){
	//Je stoke en session le plateau en tant qu'ancien plateau
	$_SESSION['ancien_plateau'] = serialize($p);
	//Je récupère les positions X et Y des deux psotions
	$x = substr($_GET['var1'], 0, 1);
	$y = substr($_GET['var1'], 1);
	$z = substr($_GET['var2'], 0, 1);
	$w = substr($_GET['var2'], 1);
	
	// Je déplace le pion sur le plateau
	$p->setPion($z, $w, $p->getPion($x, $y));
	
	// Je vérifie la condition pour gagner (Tout les pions seul et aucun isolée)
	if(count($p->listePionSeul($p->getJoueurJoue())) == 7 && $p->listePionIsole($p->getJoueurJoue())[0] == null){
	
	?>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />	
	<link rel="stylesheet" type="text/css" href="style.css">  

	<div class="login">
		<div class="login-screen">
			<div class="app-title">
				<h1 style="font-size:60px">Entropie</h1>
			</div>
			<form method="post" action="">
			<div class="login-form">
				<h1> Bravo ! Vous Avez Gagné <?php echo $p->getJoueurJoue()->getPseudo(); ?> ! </h1>
	<br><br>
				<input type="submit" name="click" class="btn btn-primary btn-large btn-block" value="Recommencer"/>
			</div>
			</form>
		</div>
	</div>
	<?php
	
	
	//Si le joueur n'a pas gagné alors on passe au tour suivant 
	}else{
	$p->toursuivant();
	$_SESSION['plateau'] = serialize($p);
	echo $p->affichage();
	}
}
// Si on ne dispose que du pion a déplacé dans l'URL longue on affiche les déplacement possible pour ce pion
else if(isset($_GET['var1'])==true){
	$_SESSION['plateau'] = serialize($p);
	echo $p->affichage2();
}
// Autrement on affiche normalement le tableau (On a le tableau en ssesion mais pas de pion sélectioné ni de déplacement)
else{
	$_SESSION['plateau'] = serialize($p);
	echo $p->affichage();
}

}








?>


