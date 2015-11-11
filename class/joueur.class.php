<?php


  class joueur{

    private $pseudo;
	private $joue;
	private $num;



  function __construct($nom, $numero){
    $this -> pseudo = $nom;
	$this -> joue = false;
	$this-> num = $numero;
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
  
  function getNum(){
	  if($this->num == null){
		return 0;
	  }
	  else{
		  return $this->num;
	  }
  }







  }