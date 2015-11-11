<?php
session_start();


require_once('class/joueur.class.php');
require_once('class/plateau.class.php');

if(isset($_POST["click"])){
	unset($_SESSION['plateau']);
}



if(!isset($_SESSION['plateau']) && !isset($_POST['joueur1']) && !isset($_POST['joueur2'])){
	
	?>
	
<link rel="stylesheet" type="text/css" href="style.css">  


    
	
	<div class="login">
		<div class="login-screen">
			<div class="app-title">
				<h1 style="font-size:60px">Entropie</h1>
			</div>
			<form method="post" action="">
			<div class="login-form">
				<div class="control-group">
				<input type="text" class="login-field" value="Pseudo Joueur 1" name="joueur1" id="login-name">
				</div>
				<br><br>
				<div class="control-group">
				<input type="text" class="login-field" value="Pseudo Joueur 2" name="joueur2" id="login-pass">
				</div>
	<br><br>
				<input type="submit" class="btn btn-primary btn-large btn-block" value="Commencer"/>
			</div>
			</form>
		</div>
	</div>

		
	
	<?php
}	
else if(!isset($_SESSION['plateau']) && isset($_POST['joueur1']) && isset($_POST['joueur2'])){
$j1 = new joueur($_POST['joueur1'], 1);
$j2 = new joueur($_POST['joueur2'], 2);
$j1->setJoue(true);
$p = new plateau($j1, $j2);
$_SESSION['plateau'] = serialize($p);
}

else{
	$p = unserialize($_SESSION['plateau']);
}

if(isset($_SESSION['plateau'])){

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

}

?>


