<?php

namespace App\DAO;

use App\Model\SituacaoVendaModel;

class SituacaoVendaDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllSituacaoVenda(): array
    {
        $situacao = $this->pdo
            ->query('SELECT
                    id_situacao,
                    descricao_situacao
                    FROM situacao_venda;')
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $situacao;
    }

    public function getLastInsertedId_situacao(): int
    {
        $statement = $this->pdo
            ->query('SELECT COALESCE(MAX(id_situacao), 0) AS max_id_situacao FROM situacao_venda');
        $result = $statement
            ->fetch(\PDO::FETCH_ASSOC);

        return $result['max_id_situacao'];
    }

    public function insertSituacaoVenda(SituacaoVendaModel $situacao): bool
    {

        $checkQuery = 'SELECT COUNT(*) FROM situacao_venda WHERE descricao_situacao = :descricao_situacao';
        $checkStatement = $this->pdo->prepare($checkQuery);
        $checkStatement->execute(['descricao_situacao' => $situacao->getdescricao_situacao()]);
        $descricao_situacaoExists = (bool)$checkStatement->fetchColumn();

        if ($descricao_situacaoExists) {

            return false;
        }

        $id_situacao_aux = $this->getLastInsertedId_situacao();
        $nextid_situacao = $id_situacao_aux + 1;


        $statement = $this->pdo
            ->prepare('INSERT INTO situacao_venda VALUES(
                :id_situacao,
                :descricao_situacao
            );');
    
        $statement->execute([
            'id_situacao' => $nextid_situacao,
            'descricao_situacao' => $situacao->getdescricao_situacao()
        ]);

        return true;

    }

    public function updateSituacaoVenda(SituacaoVendaModel $situacao): void
    {

        $id_situacao = $situacao->getId_situacao();

        $statement = $this->pdo->prepare('UPDATE situacao_venda SET 
            descricao_situacao = :descricao_situacao
            WHERE id_situacao = :id_situacao
        ');

        $statement->execute([
            'id_situacao' => $id_situacao,
            'descricao_situacao' => $situacao->getdescricao_situacao()
        ]);

    }

    public function deleteSituacaoVenda(SituacaoVendaModel $situacao): void
    {

        $id_situacao = $situacao->getId_situacao();

        $statement = $this->pdo
            ->prepare('DELETE FROM situacao_venda WHERE id_situacao = :id_situacao');
        $statement->execute([
            'id_situacao' => $id_situacao
        ]);
    }

}