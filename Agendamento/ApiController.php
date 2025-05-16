<?php
#
namespace App\Controllers\Agendamento;
#
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
# 
use App\Controllers\Agendamento\DbController;
use App\Controllers\Pattern\TokenCsrfController;
use App\Controllers\Pattern\MessageController;
use App\Controllers\Pattern\SBaseController;
use App\Controllers\Pattern\CalendarController;
# 
use Exception;

class ApiController extends ResourceController
{
    use ResponseTrait;
    private $calendario;
    private $ModelResponse;
    private $uri;
    private $recebeBase;
    private $tokenCsrf;
    private $DbController;
    private $message;

    public function __construct()
    {
        $this->recebeBase = new SBaseController();
        $this->uri = new \CodeIgniter\HTTP\URI(current_url());
        $this->calendario = new CalendarController();
        $this->DbController = new DbController();
        $this->tokenCsrf = new TokenCsrfController();
        $this->message = new MessageController();
        #
    }

    # route POST /www/index.php/index.php/project/method
    # route GET /www/index.php/index.php/project/method
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

    # route POST /www/index.php/index.php/projeto/objeto/api/cadastrar/(:any)
    # route GET /www/index.php/index.php/projeto/objeto/api/cadastrar/(:any)
    # route POST /www/index.php/index.php/projeto/objeto/api/atualizar/(:any)
    # route GET /www/index.php/index.php/projeto/objeto/api/atualizar/(:any)
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
        if ($getMethod === 'GET') {
            $apiRespond['getMethod'] = $request->getMethod();
            $apiRespond['method'] = __METHOD__;
            $apiRespond['function'] = __FUNCTION__;
            $apiRespond['message'] = '403 Forbidden - Directory access is forbidden.';
            return $this->response->setStatusCode(403)->setJSON($apiRespond);
        }
        #
        try {
            #
            $token_csrf = (isset($processRequest['token_csrf']) ? $processRequest['token_csrf'] : 'erro');
            $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
            $choice_update = (isset($processRequest['id']) && !empty($processRequest['id'])) ? (true) : (false);
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


    # route POST /www/index.php/index.php/projeto/objeto/api/filtrar/(:any)
    # route GET /www/index.php/index.php/projeto/objeto/api/filtrar/(:any)
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function dbFilter($parameter = NULL)
    {
        $request = service('request');
        $apiRespond['getMethod'] = $request->getMethod();
        $apiRespond['method'] = __METHOD__;
        $apiRespond['function'] = __FUNCTION__;
        $apiRespond['message'] = '403 Forbidden - Directory access is forbidden.';
        return $this->response->setStatusCode(403)->setJSON($apiRespond);
    }

        # route POST /www/novo/agendamento/api/calendar/(:any)
    # route GET /www/novo/agendamento/api/calendar/(:any)
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function dbReadCalendar($parameter1 = NULL, $parameter2 = NULL, $parameter3 = NULL)
    {
        # Parâmentros para receber um POST
        $falha = [
            'message' => ['danger' => 'falha na data recebida'],
            'page_title' => 'Application title',
            'getURI' => $this->uri->getSegments(),
        ];
        $request = service('request');
        $getMethod = $request->getMethod();
        $getGet = $this->request->getGet('page');
        $page = (isset($getGet) && !empty($getGet)) ? ($getGet) : (1);
        $processRequest = (array) $request->getVar();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        $data_calendario = $this->recebeBase->recebeData($parameter1, $parameter2, $parameter3);
        #
        // myPrint($processRequest, 'src\app\Controllers\AgendamentoApiController.php', true);
        // myPrint($data_calendario, 'src\app\Controllers\AgendamentoApiController.php');
        #
        if ($parameter1 !== NULL && $parameter2 !== NULL) {
            $requestDb['calendario'] = $this->calendario->getDiasMes($parameter1, $parameter2);
        } elseif ($parameter1 !== NULL && $parameter2 == NULL && $this->calendario->validarData($parameter1)) {
            // Valida o formato da data completa usando regex: YYYY-MM-DD
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $parameter1)) {
                return $falha;
            }

            // Divide a data em ano, mês e dia
            list($ano, $mes, $dia) = explode('-', $parameter1);

            // Valida se ano, mês e dia são numéricos
            if (!is_numeric($ano) || !is_numeric($mes) || !is_numeric($dia)) {
                return $falha;
            }

            // Verifica o intervalo do mês (1 a 12) e se o ano tem 4 números
            if ((int) $ano < 0 || strlen($ano) !== 4 || (int) $mes < 1 || (int) $mes > 12) {
                return $falha;
            }
            $requestDb['calendario'] = $this->calendario->getDiasMes($ano, $mes);
        }
        # $getCalendario = $this->calendario->getDiasMes($ano, $mês;

        $requestDb['agendamento'] = $this->DbController->dbReadCalendar($data_calendario, $page);
        #
        $foreach_calendario = isset($requestDb['calendario']['dias']) ? ($requestDb['calendario']['dias']) : (array());
        $foreach_agendamento = isset($requestDb['agendamento']['dbResponse']) ? ($requestDb['agendamento']['dbResponse']) : (array());

        #
        // myPrint($foreach_calendario, '', true);
        // myPrint($foreach_agendamento, '');
        #
        if ($parameter1 !== NULL && $parameter2 !== NULL || $this->calendario->validarData($parameter1)) {
            foreach ($foreach_calendario as $index => $diaCalendario) {
                $ano_calendario = isset($diaCalendario['ano']) ? ($diaCalendario['ano'] . '-') : (date('Y') . '-');
                $mes_calendario = isset($diaCalendario['mes']) ? ($diaCalendario['mes'] . '-') : (date('m') . '-');
                $dia_calendario = isset($diaCalendario['dia']) ? ($diaCalendario['dia']) : (date('d'));
                $compara_calendario = $ano_calendario . $mes_calendario . $dia_calendario;

                // Inicializa o campo 'dados_agendamento' como array vazio para cada dia do calendário
                $foreach_calendario[$index]['dados_agendamento'] = [];

                foreach ($foreach_agendamento as $agendamento) {
                    $compara_agendamento = isset($agendamento['ag_data']) ? date('Y-m-d', strtotime($agendamento['ag_data'])) : null;

                    if ($compara_calendario === $compara_agendamento) {
                        // Adiciona os dados do agendamento ao array do dia do calendário quando as datas coincidem
                        $foreach_calendario[$index]['dados_agendamento'][] = $agendamento;
                    }
                }
            }
        }

        // Atualiza o resultado com os dias do calendário incluindo os agendamentos associados
        $requestDb['calendario']['dias'] = $foreach_calendario;

        try {
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
                'result' => $requestDb,
                'metadata' => [
                    'page_title' => 'Application title',
                    'getURI' => $this->uri->getSegments(),
                ]
            ];
            $response = $this->response->setJSON($apiRespond, 201);
        } catch (\Exception $e) {
            $apiRespond = [
                'message' => ['danger' => $e->getMessage()],
                'page_title' => 'Application title',
                'getURI' => $this->uri->getSegments(),
            ];
            $response = $this->response->setJSON($apiRespond, 500);
        }

        if ($json == 1) {
            return $response;
        } else {
            return $response;
        }

    }

    # route POST /www/index.php/novo/agendamento/api/exibir/(:any)
    # route GET /www/index.php/novo/agendamento/api/exibir/(:any)
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
        # 
        if (
            $processRequest === array() &&
            $json === 1
        ) {
            $apiRespond['getMethod'] = $request->getMethod();
            $apiRespond['method'] = __METHOD__;
            $apiRespond['function'] = __FUNCTION__;
            $apiRespond['message'] = '403 Forbidden - Directory access is forbidden.';
            return $this->response->setStatusCode(403)->setJSON($apiRespond);
        }
        #
        $id_agendamento = isset($processRequest['id_agendamento']) ? ($processRequest['id_agendamento']) : ($parameter);
        #
        try {
            #
            $requestDb['NOVO'] = $this->DbController->dbReadNOVO($id_agendamento, $page);
            $requestDb['DPL'] = $this->DbController->dbReadDPL($id_agendamento, $page);
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


    # route POST /www/index.php/index.php/exemple/group/api/exibir/(:any))
    # route GET /www/index.php/index.php/exemple/group/api/exibir/(:any))
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function NovoMethodApiRest($parameter = NULL)
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


    # route POST /www/index.php/index.php/projeto/objeto/api/deletar/(:any)
    # route GET /www/index.php/index.php/projeto/objeto/api/deletar/(:any)
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function dbDelete($parameter = NULL)
    {
        $request = service('request');
        $apiRespond['getMethod'] = $request->getMethod();
        $apiRespond['method'] = __METHOD__;
        $apiRespond['function'] = __FUNCTION__;
        $apiRespond['message'] = '403 Forbidden - Directory access is forbidden.';
        return $this->response->setStatusCode(403)->setJSON($apiRespond);
    }

    # route POST /www/index.php/index.php/projeto/objeto/api/limpar/(:any)
    # route GET /www/index.php/index.php/projeto/objeto/api/limpar/(:any)
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
}
#
?>