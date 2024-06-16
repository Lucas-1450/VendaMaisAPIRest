<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\DAO\SituacaoVendaDAO;
use App\Model\SituacaoVendaModel;

final class SituacaoVendaController
{
    public function getSituacaoVenda(Request $request, Response $response, $args): Response
    {
        $situacaoDAO = new SituacaoVendaDAO();
        $situacao = $situacaoDAO->getAllSituacaoVenda();

        if($situacao){
            $response = $response->withJson($situacao);
        }else{
            $response = $response->withJson([
                'error' => 'Informativo',
                'message' => 'Ainda não há Situações de Venda cadastradas.'
            ]);
        }        

        return $response;
    }

    public function insertSituacaoVenda(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $situacaoDAO = new SituacaoVendaDAO();
        $situacao = new SituacaoVendaModel();
        $situacao->setdescricao_situacao($data['descricao_situacao']);
        $isInserted = $situacaoDAO->insertSituacaoVenda($situacao);

        if(!$isInserted){
            $response = $response->withJson([
                'message' => 'A Situacao de Venda informada já possui cadastro no sistema.'
            ]);
        }else {
            $response = $response->withJson([
                'message' => 'Situacao de Venda inserida com sucesso!'
            ]);
        }

        return $response;
    }

    public function updateSituacaoVenda(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $situacaoDAO = new SituacaoVendaDAO();
        $situacao = new SituacaoVendaModel();
        $situacao->setId_situacao((int)$data['id_situacao'])
             ->setdescricao_situacao($data['descricao_situacao']);

        $situacaoDAO->updateSituacaoVenda($situacao);
        $message = 'Situação atualizada com sucesso!';

    
        $response = $response->withJson([
            'message' => $message
        ]);
        

        return $response;
    }

    public function deleteSituacaoVenda(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $situacaoDAO = new SituacaoVendaDAO();
        $situacao = new SituacaoVendaModel();
        $situacao->setId_situacao((int)$data['id_situacao']);

        $situacaoDAO->deleteSituacaoVenda($situacao);
        $message = 'Situção excluída com sucesso!';

        $response = $response->withJson([
            'message' => $message
        ]);

        return $response;
    }

}