<?php
  class product{
    private $name;
    private $quantity;
    private $min;

    //----------------Getters--------------------------------------- 
    function getName(){
        return $this->name;
    }
    function getQuantity(){
        return $this->quantity;
    }
    function getMin(){
        return $this->min;
    }
    //------------------Setters-------------------------------------
    function setName($name){
        $this->name = $name;
    }
    function setQuantity($quantity){
        $this->quantity = $quantity;
    }
    function setMin($min){
        $this->min = $min;
    }
}
