<?php
  class costumer{
    private $name;
    private $number;
    private $b_date;

    //----------------Getters--------------------------------------- 
    function getName(){
        return $this->name;
    }
    function getNumber(){
        return $this->number;
    }
    function getBDate(){
        return $this->b_date;
    }
    //------------------Setters-------------------------------------
    function setName($name){
        $this->name = $name;
    }
    function setNumber($number){
        $this->number = $number;
    }
    function setBDate($b_date){
        $this->b_date = $b_date;
    }
}
