<?php

namespace App\DAO;

use App\Model\ClienteModel;

class ClienteDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllClientes(): array
    {
        $clientes = $this->pdo
            ->query('SELECT
                    id_cliente,
                    nome,
                    cpf,
                    telefone,
                    endereco
                    FROM cliente
                    ORDER BY id_cliente;')
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $clientes;
    }

    public function getLastInsertedId_cliente(): int
    {
        $statement = $this->pdo
            ->query('SELECT COALESCE(MAX(id_cliente), 0) AS max_id_cliente FROM cliente');
        $result = $statement
            ->fetch(\PDO::FETCH_ASSOC);

        return $result['max_id_cliente'];
    }

    public function insertCliente(ClienteModel $cliente): bool
    {

        $checkQuery = 'SELECT COUNT(*) FROM cliente WHERE cpf = :cpf';
        $checkStatement = $this->pdo->prepare($checkQuery);
        $checkStatement->execute(['cpf' => $cliente->getCpf()]);
        $cpfExists = (bool)$checkStatement->fetchColumn();

        if ($cpfExists) {

            return false;
        }

        $id_cliente_aux = $this->getLastInsertedId_cliente();
        $nextid_cliente = $id_cliente_aux + 1;


        $statement = $this->pdo
            ->prepare('INSERT INTO cliente VALUES(
                :id_cliente,
                :nome,
                :cpf,
                :telefone,
                :endereco
            );');
    
        $statement->execute([
            'id_cliente' => $nextid_cliente,
            'nome' => $cliente->getNome(),
            'cpf' => $cliente->getCpf(),
            'telefone' =>$cliente->getTelefone(),
            'endereco' =>$cliente->getEndereco()
        ]);

        return true;

    }

    public function updateCliente(ClienteModel $cliente): void
    {

        $id_cliente = $cliente->getId_cliente();

        $statement = $this->pdo->prepare('UPDATE cliente SET 
            nome = :nome,
            cpf = :cpf,
            telefone = :telefone,
            endereco = :endereco
            WHERE id_cliente = :id_cliente
        ');

        $statement->execute([
            'id_cliente' => $id_cliente,
            'nome' => $cliente->getNome(),
            'cpf' => $cliente->getCpf(),
            'telefone' => $cliente->getTelefone(),
            'endereco' => $cliente->getEndereco()
        ]);
    }

    public function deleteCliente(ClienteModel $cliente): void
    {

        $id_cliente = $cliente->getId_cliente();

        $statement = $this->pdo
            ->prepare('DELETE FROM cliente WHERE id_cliente = :id_cliente');
        $statement->execute([
            'id_cliente' => $id_cliente
        ]);
    }
}