<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\DAO\ProdutoDAO;
use App\Model\ProdutoModel;

final class ProdutoController
{
    public function getProduto(Request $request, Response $response, $args): Response
    {
        $produtoDAO = new ProdutoDAO();
        $produto = $produtoDAO->getAllProdutos();

        if($produto){
            $response = $response->withJson($produto);
        }else{
            $response = $response->withJson([
                'error' => 'Informativo',
                'message' => 'Ainda não há Produtos cadastrados.'
            ]);
        }

        return $response;
    }

    public function insertProduto(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $produtoDAO = new ProdutoDAO();
        $produto = new ProdutoModel();
        $produto->setdescricao_produto($data['descricao_produto'])
                ->setPreco((float)$data['preco'])
                ->setQtdStq($data['qtd_stq']);

        $isInserted = $produtoDAO->insertProduto($produto);
        
        if(!$isInserted){
            $response = $response->withJson([
                'message' => 'O produto informado já possui cadastro no sistema.'
            ]);
        }else {
            $response = $response->withJson([
                'message' => 'Produto inserido com sucesso!'
            ]);
        }


        return $response;
    }

    public function updateProduto(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $produtoDAO = new ProdutoDAO();
        $produto = new ProdutoModel();
        $produto->setId_produto((int)$data['id_produto'])
             ->setdescricao_produto($data['descricao_produto'])
             ->setPreco((float)$data['preco'])
             ->setQtdStq($data['qtd_stq']);

        $produtoDAO->updateProduto($produto);
        $message = 'Produto atualizado com sucesso!';

    
        $response = $response->withJson([
            'message' => $message
        ]);
        

        return $response;
    }


    public function deleteProduto(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $produtoDAO = new ProdutoDAO();
        $produto = new ProdutoModel();
        $produto->setId_produto((int)$data['id_produto']);

        $produtoDAO->deleteProduto($produto);
        $message = 'Produto excluído com sucesso!';

        $response = $response->withJson([
            'message' => $message
        ]);

        return $response;
    }

}