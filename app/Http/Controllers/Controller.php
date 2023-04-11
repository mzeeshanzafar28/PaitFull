<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function isExists($digit1, $digit2, $checkIn){
        foreach($checkIn as $row){
            if($row['digit1'] == $digit1 && $row['digit2'] == $digit2){
                return true;
            }elseif($row['digit1'] == $digit2 && $row['digit2'] == $digit1){
                return true;
            }
        }
        return false;
    }
    public function questionId(){
        return strtoupper(Str::random(4));
    }
    public function getQuestionDigits($sign){
        if($sign == "+"){
            $digit1 = rand(1, 9);
            $digit2 = rand(1, 9);
            $answer = $digit1 + $digit2;
        }elseif($sign == "-"){
            $digit1 = rand(3, 15);
            $digit2 = rand(1, $digit1 - 1);
            $answer = $digit1 - $digit2;
        }elseif($sign == "*"){
            $digit1 = rand(1, 9);
            $digit2 = rand(1, 9);
            $answer = $digit1 * $digit2;
        }elseif($sign == "/"){
            $digit1 = rand(1, 9);
            $digit2 = rand(1, 9);
            $result = $digit1 * $digit2;
            $temp = $digit1;
            $digit1 = $result;
            $answer = $temp;
        }
        return [
            'digit1' => $digit1,
            'digit2' => $digit2,
            'answer' => $answer,
        ];
    }
    public function winCombos(){
        $combos = [
            [0,1,2,3,4],
            [5,6,7,8,9],
            [10,11,12,13,14],
            [15,16,17,18,19],
            [20,21,22,23,24],
            [0,5,10,15,20],
            [1,6,11,16,21],
            [2,7,12,17,22],
            [3,8,13,18,23],
            [4,9,14,19,24],
        ];
        return $combos;
    }
}
