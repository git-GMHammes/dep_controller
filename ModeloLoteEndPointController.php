<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
// use App\Models\NomeModel;
use Exception;

class ModeloLoteEndPointController extends ResourceController
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
        return NULL;
    }

    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [view]
    public function index($parameter = NULL)
    {
        myPrint('ERRO: 403 Forbidden');
    }

    # Consumo de API
    # route GET /www/lote/endpoint/buscar/(:any)
    # route POST /www/lote/endpoint/buscar/
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function buscar($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            // 'sigla/title',
            // 'sigla/menu',
            // 'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/buscar', $apiRespond);
    }

    # Consumo de API
    # route GET /www/sigla/rota
    # route POST /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function carregarLote($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/carregar', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/novo/(:any)
    # route POST /www/lote/endpoint/novo
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function criar($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            // 'sigla/title',
            // 'sigla/menu',
            // 'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/novo', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/desfazer/(:any)
    # route POST /www/lote/endpoint/desfazer
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function desfazerListar($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/desfazer_listar', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/desfazerseparacao/(:any)
    # route POST /www/lote/endpoint/desfazerseparacao
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function desfazerSeparacao($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/desfazer_separacao', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/destruir/(:any)
    # route POST /www/lote/endpoint/destruir
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function destruir($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/destruir_listar', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/destruirformcomissao/(:any)
    # route POST /www/lote/endpoint/destruirformcomissao
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function destruirFormComissao($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/destruir_form_comissao', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/expedir/(:any)
    # route POST /www/lote/endpoint/expedir
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function expedirListar($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/expedir_listar', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/expedirmanter/(:any)
    # route POST /www/lote/endpoint/expedirmanter
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function expedirManter($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/expedir_manter', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/realocar/(:any)
    # route POST /www/lote/endpoint/realocar
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function realocarListar($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/realocar', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/receber/(:any)
    # route POST /www/lote/endpoint/receber
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function receber($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/receber', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/separar/(:any)
    # route POST /www/lote/endpoint/separar
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function separar($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/separar', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/alienar/(:any)
    # route POST /www/lote/endpoint/alienar
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function alienarListar($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/alienar', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/avaliar/(:any)
    # route POST /www/lote/endpoint/avaliar
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function avaliarListar($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/avaliar', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/avaliarmanter/(:any)
    # route POST /www/lote/endpoint/avaliarmanter
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function avaliarManter($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/avaliar_manter', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/periciar/(:any)
    # route POST /www/lote/endpoint/periciar
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function periciarListar($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/periciar', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/periciarmanter/(:any)
    # route POST /www/lote/endpoint/periciarmanter
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function periciarManter($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/periciar_manter', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/registrardescarte/(:any)
    # route POST /www/lote/endpoint/registrardescarte
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function registrarDescarte($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/registrar_descarte', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/registrardescartemanter/(:any)
    # route POST /www/lote/endpoint/registrardescartemanter
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function registrarDescarteManter($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/registrar_descarte_manter', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/registrardestinacao/(:any)
    # route POST /www/lote/endpoint/registrardestinacao
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function registrarDestinacao($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/registrar_destinacao', $apiRespond);
    }

    # Consumo de API
    # route GET /www/sigla/rota
    # route POST /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function registrarDestinacaoManter($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/registrar_destinacao_manter', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/registrardestinacaoprazo/(:any)
    # route POST /www/lote/endpoint/registrardestinacaoprazo
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function registrarDestinacaoPrazo($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/registrar_destinacao_prazo', $apiRespond);
    }

    # Consumo de API
    # route GET www/lote/endpoint/registrardestinacaoprazomanter/(:any)
    # route POST www/lote/endpoint/registrardestinacaoprazomanter
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function registrarDestinacaoPrazoManter($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/registrar_destinacao_prazo_manter', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/registrardevolucao/(:any)
    # route POST /www/lote/endpoint/registrardevolucao
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function registrardevolucao($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/registrar_devolucao', $apiRespond);
    }

    # Consumo de API
    # route GET /www/sigla/rota
    # route POST /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function registrarDevolucaoManter($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/registrar_devolucao_manter', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/registrardoacao/(:any)
    # route POST /www/lote/endpoint/registrardoacao
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function registrarDoacao($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/doacao_listar', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/registrardoacaomanter/(:any)
    # route POST /www/lote/endpoint/registrardoacaomanter
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function registrarDoacaoManter($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/registrar_doacao_manter', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/registraruso/(:any)
    # route POST /www/lote/endpoint/registraruso
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function registrarUso($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/registrar_uso', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/registrarloteleilao/(:any)
    # route POST /www/lote/endpoint/registrarloteleilao
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function retirarLeilao($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/retirar_leilao', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/selecionarleilao/(:any)
    # route POST /www/lote/endpoint/selecionarleilao
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function selecionarLeilao($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/selecionar_leilao', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/destinarlotenaoretirado/(:any)
    # route POST /www/lote/endpoint/destinarlotenaoretirado
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function destinarNaoRetirado($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/destinar_nao_retirado', $apiRespond);
    }
    # Consumo de API
    # route GET /www/lote/endpoint/informarnaoretirado/(:any)
    # route POST /www/lote/endpoint/informarnaoretirado
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function informarNaoRetirado($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/informar_nao_retirado', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/informarnaoretiradomanter/(:any)
    # route POST /www/lote/endpoint/informarnaoretiradomanter
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function informarNaoRetiradoManter($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/informar_nao_retirado_manter', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/controladorlotesarmazenados/(:any)
    # route POST /www/lote/endpoint/f
    # Informação sobre o controller : Relatório de Lotes por Destinação
    # retorno do controller [VIEW]
    public function controladorLotesArmazenados($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/controlador_lotes_armazenados', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/relatoriorecebido/(:any)
    # route POST /www/lote/endpoint/relatoriorecebido
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function relatorioRecebido($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/relatorio_recebido', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/relatoriorecebidografico/(:any)
    # route POST /www/lote/endpoint/relatoriorecebidografico
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function relatorioRecebidoGrafico($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/relatorio_recebido_grafico', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/movimentolotebens/(:any)
    # route POST /www/lote/endpoint/movimentolotebens
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function movimentoLoteBens($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/movimento_lote_bens', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/movimentolotebensgrafico/(:any)
    # route POST /www/lote/endpoint/movimentolotebensgrafico
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function movimentoLoteBensGrafico($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/movimento_lote_bens_grafico', $apiRespond);
    }

    # Consumo de API
    # route GET /www/lote/endpoint/tipolote/(:any)
    # route POST /www/lote/endpoint/tipolote/(:any)
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function tipoLote($parameter = NULL)
    {
        $request = service('request');
        $dbRequest = (array) $request->getVar();
        $loadView = array(
            'sigla/title',
            'sigla/menu',
            'sigla/message'
        );
        try {
            # URI da API
            $uri = base_url() . '/sigla/rota/' . $parameter;
            # Decisão URI da API
            if ($dbRequest !== array()) {
                $uri = base_url() . '/sigla/rota/path/path/' . $dbRequest;
            } else {
                $uri = base_url() . '/sigla/rota/path/path/' . $parameter;
            }
            # Carrega a configuração de API
            $APIform = \Config\Services::curlrequest();
            # Recebe a API
            $requestAPIform = $APIform->request('GET', $uri);
            # Recebe o JSON da API
            $requestJSONform = json_decode($requestAPIform->getBody(), true); // true para exibir em array
            $requestJSONform = array();
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
        return view('modelodeposito/lote/tipo_lote', $apiRespond);
    }
}
