<?php
#
namespace App\Controllers\Usuario;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
#
use App\Controllers\Pattern\TokenCsrfController;
use App\Controllers\Pattern\MessageController;
// use App\Controllers\Pattern\UploadDbController;
# 
use Exception;

class ApiController extends ResourceController
{
    use ResponseTrait;
    private $ModelResponse;
    private $uri;
    private $tokenCsrf;
    private $DbController;
    private $message;
    public function __construct()
    {
        $this->uri = new \CodeIgniter\HTTP\URI(current_url());
        // $this->DbController = new DbController();
        $this->message = new MessageController();
        $this->tokenCsrf = new TokenCsrfController();
        #
    }

    # route POST www/index.php/project/method
    # route GET www/index.php/project/method
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function index($parameter = NULL)
    {
        $request = service('request');
        $apiRespond['getMethod'] = $request->getMethod();
        $apiRespond['method'] = __METHOD__;
        $apiRespond['function'] = __FUNCTION__;
        $apiRespond['message'] = '403 Forbidden - Directory access is forbidden.';
        return $this->response->setStatusCode(403)->setJSON($apiRespond);
    }

    private function setApiRespond(string $status = 'success', string $getMethod = 'GET', array $requestDb = array(), $message = 'API loading data (dados para carregamento da API)')
    {
        # $message = 'API loading data (dados para carregamento da API)',
        $apiRespond = [
            'status' => $status,
            'message' => $message,
            'date' => date('Y-m-d'),
            'api' => [
                'version' => '1.0',
                'method' => $getMethod,
                'description' => 'API Description',
                'content_type' => 'application/x-www-form-urlencoded'
            ],
            'result' => $requestDb,
            'metadata' => [
                'page_title' => 'Application title',
                'getURI' => $this->uri->getSegments(),
                // Você pode adicionar campos comentados anteriormente se forem relevantes
                // 'method' => '__METHOD__',
                // 'function' => '__FUNCTION__',
            ]
        ];

        return $apiRespond;
    }

    private function saveRequest(bool $choice_update = false, string $token_csrf = 'erro', array $processRequest = array())
    {
        $processRequestSuccess = false;
        $server = $_SERVER['SERVER_NAME'];
        if ($server !== '127.0.0.1') {
            $passToken = $this->tokenCsrf->valid_token_csrf($token_csrf);
        } else {
            $passToken = true;
        }
        if ($choice_update === true) {
            if ($passToken) {
                $id = (isset($processRequest['id'])) ? ($processRequest['id']) : (array());
                $dbResponse = $this->DbController->dbUpdate($id, $processRequest);
                if (isset($dbResponse["affectedRows"]) && $dbResponse["affectedRows"] > 0) {
                    $processRequestSuccess = true;
                }
            }
        } elseif ($choice_update === false) {
            if ($passToken) {
                // return $this->response->setJSON($processRequest, 200);
                $dbResponse = $this->DbController->dbCreate($processRequest);
                if (isset($dbResponse["affectedRows"]) && $dbResponse["affectedRows"] > 0) {
                    $processRequestSuccess = true;
                }
            }
        } else {
            $this->message->message(['ERRO: Dados enviados inválidos'], 'danger');
            $dbResponse = array();
            $processRequestSuccess = false;
        }
        #
        $dbSave = [
            'processRequestSuccess' => $processRequestSuccess,
            'dbResponse' => $dbResponse,
            'status' => !isset($processRequestSuccess) || $processRequestSuccess !== true ? 'trouble' : 'success',
            'message' => !isset($processRequestSuccess) || $processRequestSuccess !== true ? 'Erro - requisição que foi bem-formada mas não pôde ser seguida devido a erros semânticos.' : 'API loading data (dados para carregamento da API)',
            'cod_http' => !isset($processRequestSuccess) || $processRequestSuccess !== true ? 422 : 201,
        ];
        #
        return $dbSave;
    }

    # route POST www/index.php/novo/user/api/cadastrar/(:any)
    # route GET www/index.php/novo/user/api/cadastrar/(:any)
    # route POST www/index.php/novo/user/api/atualizar/(:any)
    # route GET www/index.php/novo/user/api/atualizar/(:any)
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function create_update($parameter = NULL)
    {
        # Parâmentros para receber um POST
        $request = service('request');
        $getMethod = $request->getMethod();
        $processRequest = (array) $request->getVar();
        // $uploadedFiles = $request->getFiles();
        // $processRequest['assinatura'] = $this->assinatura($processRequest);
        // myPrint($processRequest, 'C:\Users\Habilidade.Com\AppData\Roaming\Code\User\snippets\php.json');
        #
        if ($getMethod == 'GET') {
            $request = service('request');
            $apiRespond['getMethod'] = $request->getMethod();
            $apiRespond['method'] = __METHOD__;
            $apiRespond['function'] = __FUNCTION__;
            $apiRespond['message'] = '403 Forbidden - Directory access is forbidden.';
            return $this->response->setStatusCode(403)->setJSON($apiRespond);
        }
        #
        $token_csrf = (isset($processRequest['token_csrf']) ? $processRequest['token_csrf'] : 'erro');
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        $choice_update = (isset($processRequest['id']) && !empty($processRequest['id'])) ? (true) : (false);
        #
        try {
            #
            $dbSave = $this->saveRequest($choice_update, $token_csrf, $processRequest);
            $apiRespond = $this->setApiRespond($dbSave['status'], $getMethod, $dbSave['dbResponse']);
            $response = $this->response->setStatusCode(201)->setJSON(body: $apiRespond);
        } catch (\Exception $e) {
            $apiRespond = $this->setApiRespond('error', $getMethod, $processRequest, $e->getMessage());
            $response = $this->response->setStatusCode(500)->setJSON($apiRespond);
        }
        #
        if ($json) {
            return $response;
            // return redirect()->to('project/endpoint/parameter/parameter/' . $parameter);
        } else {
            // return redirect()->back();
            return $response;
        }
    }


    # route POST www/index.php/novo/user/api/listar/(:any)
    # route GET www/index.php/novo/user/api/listar/(:any)
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function dbRead($parameter = NULL)
    {
        # Parâmentros para receber um POST
        $request = service('request');
        $getMethod = $request->getMethod();
        $pageGet = $this->request->getGet('page');
        $limitGet = $this->request->getGet('limit');
        $limit = (isset($limitGet) && !empty($limitGet)) ? ($limitGet) : (10);
        $page = (isset($pageGet) && !empty($pageGet)) ? ($pageGet) : (1);
        $processRequest = (array) $request->getVar();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        $id = isset($processRequest['id']) ? ($processRequest['id']) : ($parameter);
        #
        // myPrint($getMethod, 'C:\Users\Habilidade.Com\AppData\Roaming\Code\User\snippets\php.json');
        try {
            #
            $requestDb = $this->DbController->dbRead($id, $page, $limit);
            #
            $apiRespond = $this->setApiRespond('success', $getMethod, $requestDb);
            $response = $this->response->setStatusCode(201)->setJSON($apiRespond);
        } catch (\Exception $e) {
            $apiRespond = $this->setApiRespond('error', $getMethod, $requestDb, $e->getMessage());
            // myPrint('Exception $e :: ', $e->getMessage());
            $response = $this->response->setStatusCode(500)->setJSON($apiRespond);
        }
        if ($json == 1) {
            return $response;
            // return redirect()->back();
            // return redirect()->to('project/endpoint/parameter/parameter/' . $parameter);
        } else {
            return $response;
        }
    }

    # route POST www/index.php/novo/user/api/filtrar/(:any)
    # route GET www/index.php/novo/user/api/filtrar/(:any)
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function dbFilter($parameter = NULL)
    {
        # Parâmentros para receber um POST
        $request = service('request');
        $getMethod = $request->getMethod();
        $pageGet = $this->request->getGet('page');
        $limitGet = $this->request->getGet('limit');
        $limit = (isset($limitGet) && !empty($limitGet)) ? ($limitGet) : (10);
        $page = (isset($pageGet) && !empty($pageGet)) ? ($pageGet) : (1);
        $processRequest = (array) $request->getVar();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        $id = isset($processRequest['id']) ? ($processRequest['id']) : ($parameter);
        #
        // myPrint($getMethod, 'C:\Users\Habilidade.Com\AppData\Roaming\Code\User\snippets\php.json');
        try {
            #
            $requestDb = $this->DbController->dbFilter($processRequest, $page, $limit);
            #
            $apiRespond = $this->setApiRespond('success', $getMethod, $requestDb);
            $response = $this->response->setStatusCode(201)->setJSON($apiRespond);
        } catch (\Exception $e) {
            $apiRespond = $this->setApiRespond('error', $getMethod, $requestDb, $e->getMessage());
            // myPrint('Exception $e :: ', $e->getMessage());
            $response = $this->response->setStatusCode(500)->setJSON($apiRespond);
        }
        if ($json == 1) {
            return $response;
            // return redirect()->back();
            // return redirect()->to('project/endpoint/parameter/parameter/' . $parameter);
        } else {
            return $response;
        }
    }

    # route POST www/index.php/novo/user/api/deletar/(:any)
    # route GET www/index.php/novo/user/api/deletar/(:any)
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function dbDelete($parameter1 = NULL, $parameter2 = NULL)
    {
        $request = service('request');
        $getMethod = $request->getMethod();
        $processRequest = (array) $request->getVar();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;

        try {
            // $this->checkMedicalRecords('cadastros', $parameter1);
            if (
                $parameter1 !== NULL
                && $parameter2 == 'eliminar'
                // && $this->checkMedicalRecords('cadastros', $parameter1)
            ) {
                // myPrint($parameter1, 'C:\Users\Habilidade.Com\AppData\Roaming\Code\User\snippets\php.json', true);
                #
                $dbResponse = $this->DbController->dbDelete($parameter1);
                #
                $this->message->message(['Registro Eliminado com sucesso com Sucesso.'], 'success', $dbUpdate = array(), 5);
            } elseif (
                $parameter1 !== NULL
                && $parameter2 == 'restaurar'
            ) {
                #
                $dbUpdate = array(
                    'deleted_at' => null
                );
                #
                $dbResponse = $this->DbController->dbUpdate($parameter1, $dbUpdate);
                $this->message->message(['Registro Restaurado com sucesso com Sucesso.'], 'success', $dbUpdate = array(), 5);
            } elseif (
                $parameter1 !== NULL
                // && $this->checkMedicalRecords('cadastros', $parameter1)
            ) {
                $dbUpdate = array(
                    'deleted_at' => date('Y-m-d H:i:s')
                );
                #
                $dbResponse = $this->DbController->dbUpdate($parameter1, $dbUpdate);
                #
                $this->message->message(['Registro Excluído com Sucesso.'], 'success', $dbUpdate = array(), 5);
            } else {
                #
                $this->message->message(['Erro ao Excluir o Registro.'], 'warning', $dbUpdate = array(), 5);
                #
            }
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
                'result' => $dbResponse,
                'metadata' => [
                    'page_title' => 'Application title',
                    'getURI' => $this->uri->getSegments(),
                    // Você pode adicionar campos comentados anteriormente se forem relevantes
                    // 'method' => '__METHOD__',
                    // 'function' => '__FUNCTION__',
                ]
            ];
            $response = $this->response->setStatusCode(201)->setJSON($apiRespond);
        } catch (\Exception $e) {
            $apiRespond = array(
                'message' => array('danger' => $e->getMessage()),
                'page_title' => 'Application title',
                'getURI' => $this->uri->getSegments(),
            );
            // $this->returnFunction(array($e->getMessage()), 'danger',);
            $response = $this->response->setStatusCode(500)->setJSON($apiRespond);
        }
        if ($json == 1) {
            return $response;
            // return redirect()->back();
            // return redirect()->to('project/endpoint/parameter1/parameter/' . $parameter);
        } else {
            return $response;
            // return redirect()->back();
        }
    }

    # route POST www/index.php/novo/user/api/limpar/(:any)
    # route GET www/index.php/novo/user/api/limpar/(:any)
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function dbClear($parameter = NULL)
    {
        $request = service('request');
        $apiRespond['getMethod'] = $request->getMethod();
        $apiRespond['method'] = __METHOD__;
        $apiRespond['function'] = __FUNCTION__;
        $apiRespond['message'] = '403 Forbidden - Directory access is forbidden.';
        return $this->response->setStatusCode(403)->setJSON($apiRespond);
    }

    # route POST /www/index.php/novo/usuario/api/off/(:any)
    # route GET /www/index.php/novo/usuario/api/off/(:any)
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function offLine($parameter = NULL)
    {

        $gov_br = array(
            'nome' => 'Caio Marinhoi',
            'email' => 'teste@rteste.com.br',
            'telefone' => '99999999999',
            'sigla' => 'PRODERJ',
            'orgao' => 'Centro de Tecnologia da Informação e Comunicação do Estado do Rio de Janeiro',
            'tratamento' => 'Exmo',
            'setor' => 'GERFS',
            'endereco' => 'Rua da Assembleia, 10 - 10º andar - Centro - Rio de Janeiro - RJ',
            'cep' => '20011-901',
            'cidade' => 'Rio de Janeiro',
            'estado' => 'RJ',
            'pais' => 'Brasil',
            'token_csrf' => $this->tokenCsrf->token_csrf(),
        );

        $apiRespond = array(
            'name_session' => 'gov_br',
            'time_in_seconds' => 60 * 5,
            'gov_br' => $gov_br,
        );

        session()->set($apiRespond['name_session'], $apiRespond);
        session()->markAsTempdata($apiRespond['name_session'], $apiRespond['time_in_seconds']);

        $varSession = (session()->get('gov_br')) ? (session()->get('gov_br')) : (array());
        $montaJSON = $this->setApiRespond('success', 'GET', $varSession);

        // Converter o array para uma string JSON
        $jsonData = json_encode($montaJSON);

        // Definir o cookie com o conteúdo JSON
        $cookieOptions = [
            'name' => 'gov_br_data',
            'value' => $jsonData,
            'expire' => 60*5,
            'path' => '/',
            'domain' => '',
            'secure' => false,
            'httponly' => false,
            'samesite' => 'Lax'
        ];

        // Usar setcookie() da classe Response
        if (!$this->response) {
            $this->response = service('response');
        }
        $this->response->setCookie($cookieOptions);

        // Retornar a resposta JSON
        $applyReturnInFunction = $this->uri->getSegments();
        if (
            in_array(
                'novo',
                $applyReturnInFunction
            )
            && in_array(
                'usuario',
                $applyReturnInFunction
            )
            && in_array(
                'api',
                $applyReturnInFunction
            )
            && in_array(
                'off',
                $applyReturnInFunction
            )
        ) {
            return $this->response->setStatusCode(201)->setJSON($montaJSON);
        }
    }
}
#
?>