<?php
  class expense{
    private $cash;
    private $description;
    private $expense_date;

    //----------------Getters--------------------------------------- 
    function getCash(){
        return $this->cash;
    }
    function getDescription(){
        return $this->description;
    }
    function getExpenseDate(){
        return $this->expense_date;
    }
    //------------------Setters-------------------------------------
    function setCash($cash){
        $this->cash = $cash;
    }
    function setDescription($description){
        $this->description = $description;
    }
    function setExpenseDate($expense_date){
        $this->expense_date = $expense_date;
    }
}
