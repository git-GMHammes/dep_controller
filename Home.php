<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function openShift(): string
    {
        echo "Sucesso 201 - OpenShift (do Codeigniter 4)";
        return 'texto';
    }
}
