<?php

namespace App\DAO;

use App\Model\ProdutoModel;

class ProdutoDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllProdutos(): array
    {
        $produto = $this->pdo
            ->query('SELECT
                    id_produto,
                    descricao_produto,
                    preco,
                    qtd_stq
                    FROM produto
                    ORDER BY id_produto;')
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $produto;
    }

    public function getLastInsertedId_produto(): int
    {
        $statement = $this->pdo
            ->query('SELECT COALESCE(MAX(id_produto), 0) AS max_id_produto FROM produto');
        $result = $statement
            ->fetch(\PDO::FETCH_ASSOC);

        return $result['max_id_produto'];
    }

    public function insertProduto(ProdutoModel $produto): bool
    {

        $checkQuery = 'SELECT COUNT(*) FROM produto WHERE descricao_produto = :descricao_produto';
        $checkStatement = $this->pdo->prepare($checkQuery);        
        $checkStatement->execute(['descricao_produto' => $produto->getdescricao_produto()]);
        $descricao_produtoExists = (bool)$checkStatement->fetchColumn();

        if ($descricao_produtoExists) {

            return false;
        }

        $id_produto_aux = $this->getLastInsertedId_produto();
        $nextid_produto = $id_produto_aux + 1;


        $statement = $this->pdo
            ->prepare('INSERT INTO produto VALUES(
                :id_produto,
                :descricao_produto,
                :preco,
                :qtd_stq
            );');
        
        $statement->execute([
            'id_produto' => $nextid_produto,
            'descricao_produto' => $produto->getdescricao_produto(),
            'preco' => $produto->getPreco(),
            'qtd_stq' => $produto->getQtdStq()
        ]);

        return true; 

    }

    public function updateProduto(ProdutoModel $produto): void
    {

        $id_produto = $produto->getId_produto();

        $statement = $this->pdo->prepare('UPDATE produto SET 
            descricao_produto = :descricao_produto,
            preco = :preco,
            qtd_stq = :qtd_stq
            WHERE id_produto = :id_produto
        ');

        $statement->execute([
            'id_produto' => $id_produto,
            'descricao_produto' => $produto->getdescricao_produto(),
            'preco' => $produto->getPreco(),
            'qtd_stq' => $produto->getQtdStq()
        ]);
    }

    public function deleteProduto(ProdutoModel $produto): void
    {

        $id_produto = $produto->getId_produto();

        $statement = $this->pdo
            ->prepare('DELETE FROM produto WHERE id_produto = :id_produto');
        $statement->execute([
            'id_produto' => $id_produto
        ]);
    }

    public function atualizarEstoque(int $id_produto, int $qtd_vendida): void
    {
        $statement = $this->pdo
            ->prepare('UPDATE produto SET qtd_stq = qtd_stq - :qtd_vendida WHERE id_produto = :id_produto');
        $statement->bindValue(':qtd_vendida', $qtd_vendida, \PDO::PARAM_INT);
        $statement->bindValue(':id_produto', $id_produto, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function voltarEstoque(int $id_produto, int $qtd_vendida): void
    {
        $statement = $this->pdo
            ->prepare('UPDATE produto SET qtd_stq = qtd_stq + :qtd_vendida WHERE id_produto = :id_produto');
        $statement->bindValue(':qtd_vendida', $qtd_vendida, \PDO::PARAM_INT);
        $statement->bindValue(':id_produto', $id_produto, \PDO::PARAM_INT);
        $statement->execute();
    }
}