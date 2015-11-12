<?php


  class pion{

    private $joueur;



  function __construct($coul, $j){
    $this -> couleur = $coul;
    $this -> joueur = $j;
  }



  function getCouleur(){
    return $this -> couleur;
  }
	  
  function getJoueur(){
	  return $this->joueur;
  }









  }