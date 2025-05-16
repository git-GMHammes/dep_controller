<?php
#
namespace App\Controllers\Tj;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
# 
use App\Controllers\TokenCsrfController;
use App\Controllers\SystemMessageController;
use App\Controllers\AgendamentoDbController;
use App\Controllers\SystemBaseController;
use App\Controllers\SystemCalendarController;
// use App\Controllers\SystemUploadDbController;
# 
use Exception;

class WebServerMini extends ResourceController
{
    use ResponseTrait;

    # Dados MNI 2.2 (ePROC)
    private $wsdl = B53B3CB4821A96354C99D82669DD3EFB;
    private $usuario = EA7C98F3B29431C9DAA44BD391532873;
    private $senhaGerada = F106E70861C2F27847253499D672BA63;
    private $calendario;
    private $ModelResponse;
    private $uri;
    private $recebeBase;
    private $tokenCsrf;
    private $DbController;
    private $message;

    public function __construct()
    {
        $this->uri = new \CodeIgniter\HTTP\URI(current_url());
        // $this->DbController = new ObjetoDbController();
        // $this->tokenCsrf = new TokenCsrfController();
        // $this->message = new SystemMessageController();
        #
    }

    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
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

    public function gerarSenhaHash()
    {
        // Gera o hash diário conforme a orientação
        $dataAtual = date('Y-m-d');
        return hash('sha256', $dataAtual . $this->senhaGerada);
    }

    # route GET /www/index.php/novo/eproc/mni/api/consultar/(:any)
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function tjConsultation($parameter = null)
    {
        // remove mascara
        $parameter = myChar($parameter);

        $apiRespond = array(
            'status' => 'error',
            'message' => '400 Bad Request - Parâmetros obrigatórios (Nº Processo) ausentes.',
        );

        if (!$parameter) {
            return $this->response->setStatusCode(400)->setJSON($apiRespond);
        }

        $senhaHash = $this->gerarSenhaHash();

        // Configuração do cliente SOAP
        $client = new \SoapClient($this->wsdl, array(
            'trace' => true,
            'exceptions' => true,
        ));

        // Parâmetros para a consulta do processo
        $params = array(
            'idConsultante' => $this->usuario,
            'senhaConsultante' => $senhaHash,
            'numeroProcesso' => $parameter,
            'incluirCabecalho' => true,
            'incluirDocumentos' => true,
            'movimentos' => true,
        );

        try {
            // Chamada do método SOAP
            $response = $client->__soapCall('consultarProcesso', array($params));

            // Estrutura da resposta com base no exemplo fornecido
            $apiRespond = [
                'status' => $response->sucesso ? 'success' : 'error',
                'mensagem' => $response->mensagem,
            ];

            // Inclui os dados do processo se a consulta for bem-sucedida e o processo existir
            if (isset($response->processo)) {
                $apiRespond['dados'] = $response->processo;
            }

            return $this->respond($apiRespond);

        } catch (\SoapFault $fault) {
            log_message('error', 'Erro ao consultar processo: ' . $fault->getMessage());
            return $this->failServerError('Erro ao consultar processo: ' . $fault->getMessage());
        }

    }

    # route GET /# www/index.php/novo/dart/jwt/(:any)
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function darthVader($parameter = NULL)
    {
        $request = service('request');
        $getMethod = $request->getMethod();
        #
        require_once(APPPATH . 'Libraries/JWT/src/BeforeValidException.php');
        require_once(APPPATH . 'Libraries/JWT/src/ExpiredException.php');
        require_once(APPPATH . 'Libraries/JWT/src/SignatureInvalidException.php');
        require_once(APPPATH . 'Libraries/JWT/src/JWT.php');
        require_once(APPPATH . 'Libraries/JWT/src/Key.php');

        $payload = [
            'iss' => base_url(),
            'aud' => base_url(),
            'iat' => time(),
            'exp' => time() + (6 * 30 * 24 * 60 * 60),
            'data' => [
                'userId' => 'novodepositopublico',
                'email' => 'gfs@proderj.rj.gov.br'
            ]
        ];

        $secretKey = KEY_JWT;
        $jwt = \Firebase\JWT\JWT::encode($payload, $secretKey, 'HS256');
        try {
            #
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
                'result' => 'Bearer ' . $jwt,
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
            myPrint($apiRespond, 'src\app\Controllers\EprocApiController.php');
            $response = $this->response->setStatusCode(500)->setJSON($apiRespond);
        }
        return $response;

    }

    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function create_update($parameter = NULL)
    {
        $request = service('request');
        $apiRespond['getMethod'] = $request->getMethod();
        $apiRespond['method'] = __METHOD__;
        $apiRespond['function'] = __FUNCTION__;
        $apiRespond['message'] = '403 Forbidden - Directory access is forbidden.';
        return $this->response->setStatusCode(403)->setJSON($apiRespond);
    }

    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function dbRead($parameter = NULL)
    {
        $request = service('request');
        $apiRespond['getMethod'] = $request->getMethod();
        $apiRespond['method'] = __METHOD__;
        $apiRespond['function'] = __FUNCTION__;
        $apiRespond['message'] = '403 Forbidden - Directory access is forbidden.';
        return $this->response->setStatusCode(403)->setJSON($apiRespond);
    }

    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
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

    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
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