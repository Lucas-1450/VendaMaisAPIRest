<?php

namespace App\DAO;

use App\Model\FormaPgModel;

class FormapgDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllFormaPg(): array
    {
        $formapg = $this->pdo
            ->query('SELECT
                    id_forma,
                    descricao_forma
                    FROM formapg
                    ORDER BY id_forma;')
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $formapg;
    }

    public function getLastInsertedId_forma(): int
    {
        $statement = $this->pdo
            ->query('SELECT COALESCE(MAX(id_forma), 0) AS max_id_forma FROM formapg');
        $result = $statement
            ->fetch(\PDO::FETCH_ASSOC);

        return $result['max_id_forma'];
    }

    public function insertFormaPg(FormaPgModel $formapg): bool
    {

        $checkQuery = 'SELECT COUNT(*) FROM formapg WHERE descricao_forma = :descricao_forma';
        $checkStatement = $this->pdo->prepare($checkQuery);
        $checkStatement->execute(['descricao_forma' => $formapg->getdescricao_forma()]);
        $descricao_formaExists = (bool)$checkStatement->fetchColumn();

        if ($descricao_formaExists) {

            return false;
        }

        $id_forma_aux = $this->getLastInsertedId_forma();
        $nextid_forma = $id_forma_aux + 1;


        $statement = $this->pdo
            ->prepare('INSERT INTO formapg VALUES(
                :id_forma,
                :descricao_forma
            );');
    
        $statement->execute([
            'id_forma' => $nextid_forma,
            'descricao_forma' => $formapg->getdescricao_forma()
        ]);

        return true;

    }

    public function updateFormaPg(FormaPgModel $formapg): void
    {

        $id_forma = $formapg->getId_forma();

        $statement = $this->pdo->prepare('UPDATE formapg SET 
            descricao_forma = :descricao_forma
            WHERE id_forma = :id_forma
        ');

        $statement->execute([
            'id_forma' => $id_forma,
            'descricao_forma' => $formapg->getdescricao_forma()
        ]);

    }

    public function deleteFormaPg(FormaPgModel $formapg): void
    {

        $id_forma = $formapg->getId_forma();

        $statement = $this->pdo
            ->prepare('DELETE FROM formapg WHERE id_forma = :id_forma');
        $statement->execute([
            'id_forma' => $id_forma
        ]);
    }
}