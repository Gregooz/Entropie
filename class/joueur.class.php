<?php


  class joueur{

    private $pseudo;
	private $joue;
	private $num;
	private $couleur;


	/**
	 *Constructeur de la classe Joueur
	 *@param $nom : Pseudo du joueur, $numero : identifiant du joueur, $couleur : Code (HTML) couleur du joueur
	 *@return void
	*/
  function __construct($nom, $numero,  $couleur){
    $this -> pseudo = $nom;
	$this -> joue = false;
	$this-> num = $numero;
	$this-> couleur = $couleur;
  }


	/**
	 *Renvoie le Pseudo du joueur
	 *@param 
	 *@return $pseudo : le Pseudo du joueur
	*/
  function getPseudo(){
    return $this -> pseudo;
  }

	/**
	 *Permet de savoir si le joueur est actuellement en train de jouer
	 *@param 
	 *@return $joue : boolean 
	*/
  function getJoue(){
	  return $this-> joue;
  }
	  
  function setJoue($joue){
	  $this -> joue = $joue;
  }
  
  function getCouleur(){
	  return $this->couleur;
  }
  
  function getIni(){
	return substr($this->pseudo, 0, 1);	
  }
  
  function getNum(){
	  if($this->num == null){
		return 0;
	  }
	  else{
		  return $this->num;
	  }
  }







  }