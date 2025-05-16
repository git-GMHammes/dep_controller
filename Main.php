<?php

namespace App\Controllers;

class Main extends BaseController
{
    public function index()
    {
        // contar a qtd de caracter
        // $string = 'VISTORIA DETRAN 42288498';
        // echo strlen($string); // 10
        // echo "<br/>";
        // exit('src\app\Controllers\Main.php');
        return view('modelodeposito/template/index');
    }
}
