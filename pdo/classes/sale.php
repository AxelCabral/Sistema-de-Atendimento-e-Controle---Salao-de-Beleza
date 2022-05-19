<?php
  class sale{
    private $origin;
    private $value;
    private $sale_date;

    //----------------Getters--------------------------------------- 
    function getOrigin(){
        return $this->origin;
    }
    function getValue(){
        return $this->value;
    }
    function getSaleDate(){
        return $this->sale_date;
    }
    //------------------Setters-------------------------------------
    function setOrigin($origin){
        $this->origin = $origin;
    }
    function setValue($value){
        $this->value = $value;
    }
    function setSaleDate($sale_date){
        $this->sale_date = $sale_date;
    }
}
