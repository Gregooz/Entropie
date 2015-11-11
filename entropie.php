<?php
session_start();


require_once('class/joueur.class.php');
require_once('class/plateau.class.php');

if(!isset($_SESSION['plateau'])){
$j1 = new joueur("noe", 1);
$j2 = new joueur("greg", 2);
$j1->setJoue(true);
$p = new plateau($j1, $j2);
$_SESSION['plateau'] = serialize($p);
}
else{
	$p = unserialize($_SESSION['plateau']);
}










if(isset($_GET['var1'])==true && isset($_GET['var2'])==true){
	$x = substr($_GET['var1'], 0, 1);
	$y = substr($_GET['var1'], 1);
	$z = substr($_GET['var2'], 0, 1);
	$w = substr($_GET['var2'], 1);
	$p->setPion($z, $w, $p->getPion($x, $y));
	$p->toursuivant();
	$_SESSION['plateau'] = serialize($p);
	echo $p->affichage();
}

else if(isset($_GET['var1'])==true){
	$_SESSION['plateau'] = serialize($p);
	echo $p->affichage2();
}
else{
	$_SESSION['plateau'] = serialize($p);
	echo $p->affichage();
}





?>


