<?php

namespace App\Controllers\Agendamento;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\Pattern\TokenCsrfController;
use App\Controllers\Pattern\MessageController;
use App\Controllers\Pattern\SBaseController;
use  Exception;

class EndpointController1 extends ResourceController
{
    use ResponseTrait;
    private $app_template = 'novodeposito/template/main';
    private $app_message = 'novodeposito/message';
    private $app_footer = 'novodeposito/AppFooter';
    private $app_head = 'novodeposito/AppHead';
    private $app_menu = 'novodeposito/AppMenu';
    private $app_loading = 'novodeposito/AppLoading';
    private $app_json = 'novodeposito/AppJson';
    private $app_message_card = 'novodeposito/AppMessageCard';
    private $viewValidacao;
    private $viewPadroes;
    private $viewFormatacao;
    private $ModelResponse;
    private $tokenCsrf;
    private $uri;
    private $token;
    #
    public function __construct()
    {
        $this->uri = new \CodeIgniter\HTTP\URI(current_url());
        $this->tokenCsrf = new TokenCsrfController();
        $this->messagem = new MessageController();
        $this->viewValidacao = new SBaseController();
        $this->viewPadroes = new SBaseController();
        $this->viewFormatacao = new SBaseController();
        $this->token = isset($_COOKIE['token']) ? $_COOKIE['token'] : '123';
    }
    #
    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [view]
    public function index()
    {
        exit('403 Forbidden - Directory access is forbidden.');
    }
    #
    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [view]
    public function dbRead()
    {
        exit('403 Forbidden - Directory access is forbidden.');
    }

    # Consumo de API
    # route GET /www/novo/(:any)
    # route POST /www/novo/(:any)
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function dbCreate($parameter = NULL)
    {
        exit('403 Forbidden - Pagina ainda não construida.');
        // $this->token_csrf();
        $request = service('request');
        $getMethod = $request->getMethod();
        $getVar_page = $request->getVar('page');
        $processRequest = (array) $request->getVar();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        $id = (isset($processRequest['id'])) ? ('/' . $processRequest['id']) : ('/' . $parameter);
        #
        $loadView1 = array(
            $this->app_head,
            $this->app_menu,
            $this->app_message_card,
            $this->app_message,
            $this->app_loading,
            $this->app_json,
        );
        #
        $loadView2 = $this->viewValidacao->camposValidacao();
        $loadView3 = $this->viewPadroes->camposPadroes();
        $loadView4 = $this->viewFormatacao->camposFormatacao();
        #
        $loadView5 = array(
            // 'novodeposito/camposFormatacao/AppDataPtBr',
            // 'novodeposito/AppLoading',
            'novodeposito/camposValidacao/AppProcesso',
            'novodeposito/camposValidacao/AppOcorrencia',
            'novodeposito/agendamento/AppCalendario',
            'novodeposito/agendamento/AppForm',
            'novodeposito/agendamento/AppListar',
            'novodeposito/agendamento/AppCadastrar',
            'novodeposito/agendamento/AppPrincipal',
            $this->app_footer,
        );
        $loadView = array_merge($loadView1, $loadView2, $loadView3, $loadView4, $loadView5);
        // myPrint('$loadView', $loadView);
        $this->tokenCsrf->token_csrf();
        try {
            # URI da API                                                                                                          
            // $endPoint['objeto'] = myEndPoint('index.php/projeto/endereco/api/verbo', '123');
            // $requestJSONform['objeto'] = isset($endPoint['objeto']['result']) ? $endPoint['objeto']['result'] : array();
            #
            $requestJSONform = array();
            $apiRespond = [
                'status' => 'success',
                'message' => 'API loading data (dados para carregamento da API)',
                'date' => date('Y-m-d'),
                'api' => [
                    'version' => '1.0',
                    'method' => $getMethod,
                    'description' => 'API Description',
                    'content_type' => 'application/x-www-form-urlencoded'
                ],
                // 'method' => '__METHOD__',
                // 'function' => '__FUNCTION__',
                'result' => $processRequest,
                'loadView' => $loadView,
                'metadata' => [
                    'page_title' => 'Agendamento',
                    'getURI' => $this->uri->getSegments(),
                    // Você pode adicionar campos comentados anteriormente se forem relevantes
                    // 'method' => '__METHOD__',
                    // 'function' => '__FUNCTION__',
                ]
            ];
            if ($json == 1) {
                $response = $this->response->setJSON($apiRespond, 201);
            }
        } catch (\Exception $e) {
            $apiRespond = [
                'status' => 'error',
                'message' => $e->getMessage(),
                'date' => date('Y-m-d'),
                'api' => [
                    'version' => '1.0',
                    'method' => $getMethod,
                    'description' => 'API Criar Method',
                    'content_type' => 'application/x-www-form-urlencoded'
                ],
                'metadata' => [
                    'page_title' => 'ERRO - Agendamento',
                    'getURI' => $this->uri->getSegments(),
                ]
            ];
            if ($json == 1) {
                $response = $this->response->setJSON($apiRespond, 500);
            }
        }
        if ($json == 1) {
            return $apiRespond;
        } else {
            // return $apiRespond;
            // exit('CARALHO');
            return view($this->app_template, $apiRespond);
        }
    }

    # Consumo de API
    # route GET /www/(:any)
    # route POST /www/(:any)
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function dbCreatePlus($parameter = NULL)
    {
        exit('403 Forbidden - Ainda não construido.');
        // $this->token_csrf();
        $request = service('request');
        $getMethod = $request->getMethod();
        $getVar_page = $request->getVar('page');
        $processRequest = (array) $request->getVar();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        $id = (isset($processRequest['id'])) ? ('/' . $processRequest['id']) : ('/' . $parameter);
        #
        $loadView = array(
            $this->app_head,
            $this->app_menu,
            $this->message,
            $this->app_message_card,
            'novodeposito/AppLoading',
            'novodeposito/camposFormatacao/AppDataPtBr',
            'novodeposito/agendamentoPlus/AppAgendamento',
            'novodeposito/agendamentoPlus/AppListarAgendamento',
            'novodeposito/agendamentoPlus/AppCalendario',
            'novodeposito/agendamentoPlus/AppPrincipal',
            $this->app_footer,
        );
        // myPrint($loadView, 'src\app\Controllers\AgendamentoEndpointController.php');
        $this->tokenCsrf->token_csrf();
        try {
            # URI da API                                                                                                          
            // $endPoint['objeto'] = myEndPoint('index.php/projeto/endereco/api/verbo', '123');
            // $requestJSONform['objeto'] = isset($endPoint['objeto']['result']) ? $endPoint['objeto']['result'] : array();
            #
            $requestJSONform = array();
            $apiRespond = [
                'status' => 'success',
                'message' => 'API loading data (dados para carregamento da API)',
                'date' => date('Y-m-d'),
                'api' => [
                    'version' => '1.0',
                    'method' => $getMethod,
                    'description' => 'API Description',
                    'content_type' => 'application/x-www-form-urlencoded'
                ],
                // 'method' => '__METHOD__',
                // 'function' => '__FUNCTION__',
                'result' => $processRequest,
                'loadView' => $loadView,
                'metadata' => [
                    'page_title' => 'Título do Método',
                    'getURI' => $this->uri->getSegments(),
                    // Você pode adicionar campos comentados anteriormente se forem relevantes
                    // 'method' => '__METHOD__',
                    // 'function' => '__FUNCTION__',
                ]
            ];
            if ($json == 1) {
                $response = $this->response->setJSON($apiRespond, 201);
            }
        } catch (\Exception $e) {
            $apiRespond = [
                'status' => 'error',
                'message' => $e->getMessage(),
                'date' => date('Y-m-d'),
                'api' => [
                    'version' => '1.0',
                    'method' => $getMethod,
                    'description' => 'API Criar Method',
                    'content_type' => 'application/x-www-form-urlencoded'
                ],
                'metadata' => [
                    'page_title' => 'ERRO - Mensagem',
                    'getURI' => $this->uri->getSegments(),
                ]
            ];
            if ($json == 1) {
                $response = $this->response->setJSON($apiRespond, 500);
            }
        }
        if ($json == 1) {
            return $apiRespond;
        } else {
            // return $apiRespond;
            // exit('CARALHO');
            return view($this->app_template, $apiRespond);
        }
    }

    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [view]
    public function dbUpdate()
    {
        exit('403 Forbidden - Directory access is forbidden.');
    }
    #
    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [view]
    public function dbDelete()
    {
        exit('403 Forbidden - Directory access is forbidden.');
    }
    #
    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [view]
    public function dbCleanner()
    {
        exit('403 Forbidden - Directory access is forbidden.');
    }
}

?>