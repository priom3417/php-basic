<?php

class Validator{

    public static function string($str, $min = 1, $max = INF){
        if(strlen(trim($str) >= $min && strlen(trim($str)) <= $max)){
            return true;
        }
        return false;
    }
}