<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\DAO\VendaDAO;
use App\Model\VendaModel;


final class VendaController
{
    public function getVenda(Request $request, Response $response, $args): Response
    {
        $VendaDAO = new VendaDAO();
        $venda = $VendaDAO->getAllVendas();

        if($venda){
            $response = $response->withJson($venda);
        }else{
            $response = $response->withJson([
                'error' => 'Informativo',
                'message' => 'Ainda não há vendas cadastradas.'
            ]);
        }

        return $response;
    }

    public function getVendaUnica(Request $request, Response $response, $args): Response
    {
        $id_venda = (int)$args['id'];
        $vendaDAO = new VendaDAO();
        $venda = $vendaDAO->getVendaById($id_venda);

        if ($venda) {
            $response = $response->withJson($venda);
        } else {
            $response = $response->withJson([
                'error' => 'Informativo',
                'message' => 'Venda não encontrada.'
            ]);
        }

        return $response;
    }

    public function insertVenda(Request $request, Response $response, $args): Response
    {

        $data = $request->getParsedBody();

        $vendaDAO = new VendaDAO();
        $venda = new VendaModel();
        $venda->setDtvenda($data['dt_venda'])
                ->setIdCliente($data['id_cliente'])
                ->setVrTotal($data['vr_total'])
                ->setVrFrete($data['vr_frete'])
                ->setDesconto($data['desconto'])
                ->setSituacao($data['situacao'])
                ->setFormaPg($data['forma_pg']);

        $vendaDAO->insertVenda($venda);

        $response = $response->withJson([
            'message' => 'Venda inserida com sucesso!'
        ]);

        return $response;
    }

    public function updateVenda(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $vendaDAO = new VendaDAO();
        $venda = new VendaModel();
        $venda->setId_venda((int)$data['id_venda'])
             ->setDtVenda($data['dt_venda'])
             ->setIdCliente($data['id_cliente'])
             ->setVrTotal($data['vr_total'])
             ->setVrFrete($data['vr_frete'])
             ->setDesconto($data['desconto'])
             ->setSituacao($data['situacao'])
             ->setFormaPg($data['forma_pg']);

        $vendaDAO->updateVenda($venda);
        $message = 'Venda atualizada com sucesso!';

    
        $response = $response->withJson([
            'message' => $message
        ]);
        

        return $response;
    }

    public function deleteVenda(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $vendaDAO = new VendaDAO();
        $venda = new VendaModel();
        $venda->setId_venda((int)$data['id_venda']);

        $vendaDAO->deleteVenda($venda);
        $message = 'Venda excluída com sucesso!';

        $response = $response->withJson([
            'message' => $message
        ]);

        return $response;
    }

}