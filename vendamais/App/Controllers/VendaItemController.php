<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\DAO\VendaItemDAO;
use App\Model\VendaItemModel;
use App\DAO\ProdutoDAO;

final class VendaItemController
{
    public function getVendaItem(Request $request, Response $response, $args): Response
    {
        $venda_itemDAO = new VendaItemDAO;
        $venda_item = $venda_itemDAO->getItem();

        if($venda_item){
            $response = $response->withJson($venda_item);
        }else{
            $response = $response->withJson([
                'error' => 'Informativo',
                'message' => 'Ainda não há itens na venda.'
            ]);
        }

        return $response;
    }

    public function getVendaItens(Request $request, Response $response, $args): Response
    {
        $id_venda = (int)$args['id'];
        $vendaitemDAO = new VendaItemDAO();
        $vendaItem = $vendaitemDAO->getItensVenda($id_venda);

        if ($vendaItem) {
            $response = $response->withJson($vendaItem);
        } else {
            $response = $response->withJson([
                'error' => 'Informativo',
                'message' => 'Itens não encontrados.'
            ]);
        }

        return $response;
    }

    public function getItemVenda(Request $request, Response $response, $args): Response
    {
        $id_venda = (int)$args['id'];
        $item = (int)$args['item'];
        $itemVendaDAO = new VendaItemDAO();
        $itemVenda = $itemVendaDAO->getItemByID($id_venda, $item);

        if($itemVenda){
            $response = $response->withJson($itemVenda);
        } else {
            $response = $response->withJson([
                'error' => 'Informativo',
                'message' => 'Erro ao carregar Item.'
            ]);
        }

        return $response;
    }

    public function insertVendaItem(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $venda_itemDAO = new VendaItemDAO();
        $venda_item = new VendaItemModel();
        $venda_item->setIdVenda($data['id_venda'])
                ->setIdProduto($data['id_produto'])
                ->setDescProduto($data['desc_produto'])
                ->setQtdProduto($data['qtd_produto'])
                ->setVrUnit($data['vr_unitario'])
                ->setVrTotal($data['vr_total']);

        $venda_itemDAO->insertVendaItem($venda_item);

        $response = $response->withJson([
            'message' => 'Item inserido com sucesso!'
        ]);

        return $response;
    }

    public function updateVendaItem(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $venda_itemDAO = new VendaItemDAO();
        $venda_item = new VendaItemModel();
        $venda_item->setIdVenda((int)$data['id_venda'])
             ->setItem($data['item'])
             ->setIdProduto($data['id_produto'])
             ->setDescProduto($data['desc_produto'])
             ->setQtdProduto($data['qtd_produto'])
             ->setVrUnit($data['vr_unitario'])
             ->setVrTotal($data['vr_total']);

        $venda_itemDAO->updateVendaItem($venda_item);
        $message = 'Item atualizado com sucesso!';

    
        $response = $response->withJson([
            'message' => $message
        ]);
        

        return $response;
    }

    public function deleteVendaItem(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $venda_itemDAO = new VendaItemDAO();
        $venda_item = new VendaItemModel();
        $venda_item->setIdVenda((int)$data['id_venda'])
             ->setItem($data['item']);

        $venda_itemDAO->deleteVendaItem($venda_item);
        $message = 'Item excluído com sucesso!';

        $response = $response->withJson([
            'message' => $message
        ]);

        return $response;
    }

    public function faturarVenda(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();
        $id_venda = $data['id_venda'];

        $venda_itemDAO = new VendaItemDAO();
        $produtoDAO = new ProdutoDAO();

        try {
            $venda_itemDAO->beginTransaction();

            $itens = $venda_itemDAO->getProdutosVenda($id_venda);

            foreach ($itens as $item) {
                $produtoDAO->atualizarEstoque($item['id_produto'], $item['qtd_produto']);
            }

            $venda_itemDAO->commit();
            
            $response = $response->withJson([
                'message' => 'Estoque atualizado!'
            ]);
        } catch (Exception $e) {
            $venda_itemDAO->rollBack();
            
            $response = $response->withJson([
                'message' => 'Erro ao atualizar o estoque: ' . $e->getMessage()
            ], 500);
        }

        return $response;
    }

    public function cancelarVenda(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();
        $id_venda = $data['id_venda'];

        $venda_itemDAO = new VendaItemDAO();
        $produtoDAO = new ProdutoDAO();

        try {
            $venda_itemDAO->beginTransaction();

            $itens = $venda_itemDAO->getProdutosVenda($id_venda);

            foreach ($itens as $item) {
                $produtoDAO->voltarEstoque($item['id_produto'], $item['qtd_produto']);
            }

            $venda_itemDAO->commit();
            
            $response = $response->withJson([
                'message' => 'Estoque atualizado!'
            ]);
        } catch (Exception $e) {
            $venda_itemDAO->rollBack();
            
            $response = $response->withJson([
                'message' => 'Erro ao atualizar o estoque: ' . $e->getMessage()
            ], 500);
        }

        return $response;
    }

}