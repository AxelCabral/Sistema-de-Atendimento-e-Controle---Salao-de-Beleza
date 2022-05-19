<?php
  class treatment{
    private $costumer_id;
    private $costumer_name;
    private $assiduity;
    private $birthday;
    private $percent_promotion;
    private $value_promotion;
    private $payment_method;
    private $treatment_price;
    private $treatment_date;

    //----------------Getters--------------------------------------- 
    function getCostumerId(){
        return $this->costumer_id;
    }
    function getCostumerName(){
        return $this->costumer_name;
    }
    function getAssiduity(){
        return $this->assiduity;
    }
    function getBirthday(){
        return $this->birthday;
    }
    function getPercentPromotion(){
        return $this->percent_promotion;
    }
    function getValuePromotion(){
        return $this->value_promotion;
    }
    function getPaymentMethod(){
        return $this->payment_method;
    }
    function getTreatmentPrice(){
        return $this->treatment_price;
    }
    function getTreatmentDate(){
        return $this->treatment_date;
    }
    //------------------Setters-------------------------------------
    function setCostumerId($costumer_id){
        $this->costumer_id = $costumer_id;
    }
    function setCostumerName($costumer_name){
        $this->costumer_name = $costumer_name;
    }
    function setAssiduity($assiduity){
        $this->assiduity = $assiduity;
    }
    function setBirthday($birthday){
        $this->birthday = $birthday;
    }
    function setPercentPromotion($percent_promotion){
        $this->percent_promotion = $percent_promotion;
    }
    function setValuePromotion($value_promotion){
        $this->value_promotion = $value_promotion;
    }
    function setPaymentMethod($payment_method){
        $this->payment_method = $payment_method;
    }
    function setTreatmentPrice($treatment_price){
        $this->treatment_price = $treatment_price;
    }
    function setTreatmentDate($treatment_date){
        $this->treatment_date = $treatment_date;
    }
}
