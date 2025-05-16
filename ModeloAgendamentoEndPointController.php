<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
// use App\Models\NomeModel;
use Exception;

class ModeloAgendamentoEndPointController extends ResourceController
{
    use ResponseTrait;
    private $ModelResponse;
    private $uri;
    private $template = 'novodeposito/template/main';
    private $message = 'novodeposito/message';
    private $footer = 'novodeposito/footer';
    private $head = 'novodeposito/head';
    private $menu = 'novodeposito/menu';

    public function __construct()
    {
        // $this->ModelResponse = new NomeModel();
        $this->uri = new \CodeIgniter\HTTP\URI(current_url());
        helper([
            'myPrint',
            'myEndPoint',
            'myDate',
            'myIdUFF',
            'form'
        ]);
    }

    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [view]
    public function index($parameter = NULL)
    {
        myPrint('ERRO: 403 Forbidden', '');
    }

    # Consumo de API
    # route GET /www/antigo/agendamento/endpoint/cadastrar/(:any)
    # route POST /www/antigo/agendamento/endpoint/cadastrar/(:any)
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function cadastrar($parameter = NULL)
    {
        try {
            $requestJSONform = array();
            $loadView = array();
            $apiRespond = [
                'http' => array(
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'method' => 'GET/POST',
                ),
                'message' => 'API loading data (dados para carregamento da API)',
                'date' => date('Y-m-d'),
                // 'method' => '__METHOD__',
                // 'function' => '__FUNCTION__',
                // 'getURI' => $this->uri->getSegments(),
                // 'protocol' => strtoupper(myIdUFF()),
                'page_title' => 'Funções',
                'result' => $requestJSONform,
                'loadView' => $loadView
            ];
        } catch (\Exception $e) {
            $apiRespond = array(
                'message' => array('danger' => $e->getMessage()),
                'loadView' => $loadView
            );
        }
        // return view('template/main', $apiRespond);
        return view('modelodeposito/agendamento/agendar_recebimento', $apiRespond);
    }
}
