<?php
namespace app\myclasses;


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MakeObject{
    static function becomeArrayToObject($array){
        //array_map((object), $array);
        foreach($array as $key => $value){
            $array[$key] = (object)$value;
        }
        return $array;
    } 
}