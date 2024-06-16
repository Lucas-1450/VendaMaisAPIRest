<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use \App\DAO\FormaPgDAO;
use \App\Model\FormaPgModel;

final class FormaPgController
{
    public function getFormaPg(Request $request, Response $response, $args): Response
    {
        $formapgDAO = new FormaPgDAO();
        $formapg = $formapgDAO->getAllFormaPg();

        if($formapg){
            $response = $response->withJson($formapg);
        }else{
            $response = $response->withJson([
                'error' => 'Informativo',
                'message' => 'Ainda não há Formas de Pagamento cadastradas.'
            ]);
        }        

        return $response;
    }

    public function insertFormaPg(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $formapgDAO = new FormaPgDAO();
        $formapg = new FormaPgModel();
        $formapg->setdescricao_forma($data['descricao_forma']);
        $isInserted = $formapgDAO->insertFormaPg($formapg);

        if(!$isInserted){
            $response = $response->withJson([
                'message' => 'A Forma de Pagamento informada já possui cadastro no sistema.'
            ]);
        }else {
            $response = $response->withJson([
                'message' => 'Forma de Pagamento inserida com sucesso!'
            ]);
        }

        return $response;
    }

    public function updateFormaPg(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $formapgDAO = new FormaPgDAO();
        $formapg = new FormaPgModel();
        $formapg->setId_forma((int)$data['id_forma'])
             ->setdescricao_forma($data['descricao_forma']);

        $formapgDAO->updateFormaPg($formapg);
        $message = 'Forma de Pagamento atualizada com sucesso!';

    
        $response = $response->withJson([
            'message' => $message
        ]);
        

        return $response;
    }

    public function deleteFormaPg(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $formapgDAO = new FormaPgDAO();
        $formapg = new FormaPgModel();
        $formapg->setId_forma((int)$data['id_forma']);

        $formapgDAO->deleteFormaPg($formapg);
        $message = 'Forma de Pagamento excluída com sucesso!';

        $response = $response->withJson([
            'message' => $message
        ]);

        return $response;
    }

}