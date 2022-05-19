<?php
  class service{
    private $service;
    private $price;

    //----------------Getters--------------------------------------- 
    function getService(){
        return $this->service;
    }
    function getPrice(){
        return $this->price;
    }
    //------------------Setters-------------------------------------
    function setService($service){
        $this->service = $service;
    }
    function setPrice($price){
        $this->price = $price;
    }
}
