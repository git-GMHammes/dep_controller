<?php
namespace App\Controllers\Tj;

use App\Controllers\BaseController;
use SoapClient;
use SoapFault;
use CodeIgniter\Config\BaseConfig;

class WebServerPRODERJ extends BaseController
{
    private $wsdl = DF91D46565E134051360E71BA159FC27;
    private $sLogin = B7143D3E16D4766A7EF9D0AFFC9E5F45;
    // private $sSenha = C8C21309118B00E6FEF638E6892AB505;
    private $sSenha = 'WKEA23';
    private $sMachine = B344A643309594F2858CD63F852076B8;
    private $sUsuarioSO = C1551D0BB5DE75540595F9B51136D5BF;
    private $sSiglaSist = C4104D6833717E7AD62E2D43B1FE08CC;
    private $codOrg = A0301FDF75CC52430D453B99B169DA5D;
    private $sUsuarioLog = DA957EB311216E5CB74B8FE603B6A47C;
    private $client;

    public function __construct()
    {
        try {
            $this->client = new SoapClient($this->wsdl, [
                'trace' => 1,
                'exceptions' => true,
                'cache_wsdl' => WSDL_CACHE_NONE
            ]);
        } catch (SoapFault $e) {
            log_message('error', 'SOAP Client initialization failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function consultar()
    {
        return false;
    }

    /**
     * Registra o sistema no PRODERJ
     */
    public function registrarSistema()
    {
        try {
            $params = [
                'sLogin' => $this->sLogin,
                'sSenha' => $this->sSenha,
                'sMachine' => $this->sMachine,
                'sUsuarioSO' => $this->sUsuarioSO,
                'sSiglaSist' => $this->sSiglaSist,
                'codOrg' => intval($this->codOrg),
                'sUsuarioLog' => $this->sUsuarioLog
            ];
            
            myPrint('$params :: ', $params);

            $result = $this->client->RegistrarSistema($params);
            myPrint('$result :: ', $result);
            log_message('info', 'Sistema registrado com sucesso no PRODERJ');
            return $result;

        } catch (SoapFault $e) {
            log_message('error', 'Erro ao registrar sistema: ' . $e->getMessage());
            myPrint('$e->getMessage() ::', $e->getMessage());
            throw $e;
        }
    }

    /**
     * Registra o usuário no PRODERJ
     */
    public function registraUsuario()
    {
        try {
            $params = [
                'sLogin' => $this->sLogin,
                'sSenha' => $this->sSenha,
                'sMachine' => $this->sMachine,
                'sUsuarioSO' => $this->sUsuarioSO,
                'sSiglaSist' => $this->sSiglaSist,
                'codOrg' => intval($this->codOrg)
            ];

            $result = $this->client->RegistraUsuario($params);
            log_message('info', 'Usuário registrado com sucesso no PRODERJ');
            return $result;

        } catch (SoapFault $e) {
            log_message('error', 'Erro ao registrar usuário: ' . $e->getMessage());
            throw $e;
        }
    }

    # WEBSERVER PRODERJ HOMOLOGAR
    # Consulta um processo no PRODERJ
    # @param string $numeroProcesso Número do processo a ser consultado
    # @return object Dados do processo consultado
    # www/index.php/novo/webserviceproderj/api/consultar/PROCESSO
    # route GET /www/index.php/novo/webserviceproderj/api/consultar/(:any)
    public function consultarProcesso($numeroProcesso = null)
    {
        // echo "<br/>" . $this->wsdl;
        // echo "<br/>" . $this->sLogin;
        // echo "<br/>" . $this->sSenha;
        // echo "<br/>" . $this->sMachine;
        // echo "<br/>" . $this->sUsuarioSO;
        // echo "<br/>" . $this->sSiglaSist;
        // echo "<br/>" . $this->codOrg;
        // echo "<br/>" . $this->sUsuarioLog;
        // echo "<br/>";
        // echo "<br/>";
        // echo "<br/>";
        // echo "<br/>";
        // exit('FIM');
        if ($numeroProcesso === null) {
            return $this->response->setJSON([
                'status' => 400,
                'message' => 'Número do processo é obrigatório',
                'success' => false
            ])->setStatusCode(400);
        }

        try {
            // Registra sistema e usuário antes da consulta
            $this->registrarSistema();
            $this->registraUsuario();

            $params = [
                'sCodProc' => $numeroProcesso
            ];

            $result = $this->client->ConsultarProcesso($params);

            if (empty($result)) {
                return $this->response->setJSON([
                    'status' => 404,
                    'message' => 'Processo não encontrado',
                    'success' => false
                ])->setStatusCode(404);
            }

            return $this->response->setJSON([
                'status' => 200,
                'message' => 'Processo consultado com sucesso',
                'success' => true,
                'data' => $result
            ])->setStatusCode(200);

        } catch (SoapFault $e) {
            $errorCode = 500;
            $errorMessage = 'Erro interno do servidor';

            // Tratamento específico para diferentes tipos de erro
            if (strpos($e->getMessage(), 'Authentication failed') !== false) {
                $errorCode = 401;
                $errorMessage = 'Falha na autenticação';
            } else if (strpos($e->getMessage(), 'Access denied') !== false) {
                $errorCode = 403;
                $errorMessage = 'Acesso negado';
            } else if (strpos($e->getMessage(), 'Service unavailable') !== false) {
                $errorCode = 503;
                $errorMessage = 'Serviço indisponível';
            }

            return $this->response->setJSON([
                'status' => $errorCode,
                'message' => $errorMessage,
                'error' => $e->getMessage(),
                'success' => false
            ])->setStatusCode($errorCode);
        }
    }

    /**
     * Finaliza a sessão do PRODERJ
     */
    public function finalizarSessao()
    {
        try {
            $result = $this->client->FinalizaSessao();
            log_message('info', 'Sessão finalizada com sucesso');
            return $result;
        } catch (SoapFault $e) {
            log_message('error', 'Erro ao finalizar sessão: ' . $e->getMessage());
            throw $e;
        }
    }
}