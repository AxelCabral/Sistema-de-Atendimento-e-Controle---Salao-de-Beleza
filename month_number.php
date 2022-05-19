<?php
    function monthNumber($month){
        if($month == "Janeiro"){
            $month_number = 1;
        }
        else if($month == "Fevereiro"){
            $month_number = 2;
        }
        else if($month == "Março"){
            $month_number = 3;
        }
        else if($month == "Abril"){
            $month_number = 4;
        }
        else if($month == "Maio"){
            $month_number = 5;
        }
        else if($month == "Junho"){
            $month_number = 6;
        }
        else if($month == "Julho"){
            $month_number = 7;
        }
        else if($month == "Agosto"){
            $month_number = 8;
        }
        else if($month == "Setembro"){
            $month_number = 9;
        }
        else if($month == "Outubro"){
            $month_number = 10;
        }
        else if($month == "Novembro"){
            $month_number = 11;
        }
        else if($month == "Dezembro"){
            $month_number = 12;
        }
        else if($month == "none" OR $month == ""){
            $month_number = 0;
        }
        return $month_number;
    }
