<?php
session_start();


<<<<<<< HEAD
echo "<div align=center><table border="."1px". ">";
=======
>>>>>>> 9cd016fc273df0d999dcfa305e4767bb6a4ccc1a


require_once('class/joueur.class.php');
require_once('class/plateau.class.php');

if(!isset($_SESSION['plateau'])){
$j1 = new joueur("Noé", 1);
$j2 = new joueur("Greg", 2);
$j1->setJoue(true);
$p = new plateau($j1, $j2);
$_SESSION['plateau'] = serialize($p);
}
else{
	$p = unserialize($_SESSION['plateau']);
}


echo "est isolé ? : " . $p->estIsolee($p->getCase(1, 1)) . "<br>";


//echo $p->test($p->getJoueurJoue());





if(isset($_GET['var1'])==true && isset($_GET['var2'])==true){
	$a = substr($_GET['var1'], 0, 1);
	$b = substr($_GET['var1'], 1);
	$z = substr($_GET['var2'], 0, 1);
	$w = substr($_GET['var2'], 1);
	$p->setPion($z, $w, $p->getPion($a, $b));
	$p->toursuivant();
	$_SESSION['plateau'] = serialize($p);
	echo $p->affichage();
}
<<<<<<< HEAD
echo "</table></div>";
=======
>>>>>>> 9cd016fc273df0d999dcfa305e4767bb6a4ccc1a

else if(isset($_GET['var1'])==true){
	$_SESSION['plateau'] = serialize($p);
	echo $p->affichage2();
}
else{
	$_SESSION['plateau'] = serialize($p);
	echo $p->affichage();
}





?>
