<?php


  class joueur{

    private $pseudo;
	private $joue;
	private $num;
	private $couleur;



  function __construct($nom, $numero,  $couleur){
    $this -> pseudo = $nom;
	$this -> joue = false;
	$this-> num = $numero;
	$this-> couleur = $couleur;
  }



  function getPseudo(){
    return $this -> pseudo;
  }


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