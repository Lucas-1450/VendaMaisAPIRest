<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\DAO\ClienteDAO;
use App\Model\ClienteModel;

final class ClienteController
{
    public function getCliente(Request $request, Response $response, $args): Response
    {
        $clienteDAO = new ClienteDAO();
        $clientes = $clienteDAO->getAllClientes();

        if($clientes){
            $response = $response->withJson($clientes);
        }else{
            $response = $response->withJson([
                'error' => 'Informativo',
                'message' => 'Ainda não há clientes cadastrados.'
            ]);
        }        

        return $response;
    }

    public function insertCliente(Request $request, Response $response, $args): Response
    {

        $data = $request->getParsedBody();

        $clienteDAO = new ClienteDAO();
        $cliente = new ClienteModel();
        $cliente->setNome($data['nome'])
                ->setCpf($data['cpf'])
                ->setTelefone($data['telefone'])
                ->setEndereco($data['endereco']);
        $isInserted = $clienteDAO->insertCliente($cliente);

        if(!$isInserted){
            $response = $response->withJson([
                'message' => 'O CPF informado já possui cadastro no sistema.'
            ]);
        }else {
            $response = $response->withJson([
                'message' => 'Cliente inserido com sucesso!'
            ]);
        }

        return $response;
    }

    public function updateCliente(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $clienteDAO = new ClienteDAO();
        $cliente = new ClienteModel();
        $cliente->setId_cliente((int)$data['id_cliente'])
             ->setNome($data['nome'])
             ->setCpf($data['cpf'])
             ->setTelefone($data['telefone'])
             ->setEndereco($data['endereco']);

        $clienteDAO->updateCliente($cliente);
        $message = 'Cliente atualizado com sucesso!';

    
        $response = $response->withJson([
            'message' => $message
        ]);
        

        return $response;
    }

    public function deleteCliente(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $clienteDAO = new ClienteDAO();
        $cliente = new ClienteModel();
        $cliente->setId_cliente((int)$data['id_cliente']);

        $clienteDAO->deleteCliente($cliente);
        $message = 'Cliente excluído com sucesso!';

        $response = $response->withJson([
            'message' => $message
        ]);

        return $response;
    }

}