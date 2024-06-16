<?php

namespace App\DAO;

use App\Model\VendaModel;

class VendaDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllVendas(): array
    {
        $venda = $this->pdo
            ->query('SELECT
                    v.id_venda,
                    v.dt_venda,
                    c.nome AS cliente,
                    v.vr_total,
                    v.vr_frete,
                    v.desconto,
                    s.descricao_situacao AS situacao,
                    f.descricao_forma AS formapg
                    FROM venda v
                    JOIN cliente c ON v.id_cliente = c.id_cliente
                    JOIN situacao_venda s ON v.situacao = s.id_situacao
                    JOIN formapg f ON v.forma_pg = f.id_forma
                    ORDER BY v.id_venda;')
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $venda;
    }

    public function getVendaById(int $id_venda): ?array
    {
        $statement = $this->pdo
            ->prepare('SELECT
                        v.id_venda,
                        v.dt_venda,
                        v.id_cliente,
                        c.nome AS cliente,
                        v.vr_total,
                        v.vr_frete,
                        v.desconto,
                        v.situacao,
                        s.descricao_situacao AS desc_situacao,
                        v.forma_pg,
                        f.descricao_forma AS formapg
                        FROM venda v
                        JOIN cliente c ON v.id_cliente = c.id_cliente
                        JOIN situacao_venda s ON v.situacao = s.id_situacao
                        JOIN formapg f ON v.forma_pg = f.id_forma
                        WHERE v.id_venda = :id_venda');
        $statement->bindParam('id_venda', $id_venda, \PDO::PARAM_INT);
        $statement->execute();
        $venda = $statement->fetch(\PDO::FETCH_ASSOC);

        return $venda ?: null;
    }

    public function getLastInsertedId_venda(): int
    {
        $statement = $this->pdo
            ->query('SELECT COALESCE(MAX(id_venda), 0) AS max_id_venda FROM venda');
        $result = $statement
            ->fetch(\PDO::FETCH_ASSOC);

        return $result['max_id_venda'];
    }

    public function insertVenda(VendaModel $venda): void
    {

        $id_venda_aux = $this->getLastInsertedId_venda();
        $nextid_venda = $id_venda_aux + 1;


        $statement = $this->pdo
            ->prepare('INSERT INTO venda VALUES(
                :id_venda,
                :dt_venda,
                :id_cliente,
                :vr_total,
                :vr_frete,
                :desconto,
                :situacao,
                :forma_pg
            );');
        
        $statement->execute([
            'id_venda' => $nextid_venda,
            'dt_venda' => $venda->getDtVenda(),
            'id_cliente' => $venda->getIdCliente(),
            'vr_total' => $venda->getVrTotal(),
            'vr_frete' => $venda->getVrFrete(),
            'desconto' => $venda->getDesconto(),
            'situacao' => $venda->getSituacao(),
            'forma_pg' => $venda->getFormaPg()
        ]);

    }

    public function updateVenda(VendaModel $venda): void
    {

        $id_venda = $venda->getId_venda();

        $statement = $this->pdo->prepare('UPDATE venda SET 
            dt_venda = :dt_venda,
            id_cliente = :id_cliente,
            vr_total = :vr_total,
            vr_frete = :vr_frete,
            desconto = :desconto, 
            situacao = :situacao, 
            forma_pg = :forma_pg 
            WHERE id_venda = :id_venda
        ');

        $statement->execute([
            'id_venda' => $id_venda,
            'dt_venda' => $venda->getDtVenda(),
            'id_cliente' => $venda->getIdCliente(),
            'vr_total' => $venda->getVrTotal(),
            'vr_frete' => $venda->getVrFrete(),
            'desconto' => $venda->getDesconto(),
            'situacao' => $venda->getSituacao(),
            'forma_pg' => $venda->getFormaPg()
        ]);
    }

    public function deleteVenda(VendaModel $venda): void
    {

        $id_venda = $venda->getId_venda();

        $statement = $this->pdo
            ->prepare('DELETE FROM venda WHERE id_venda = :id_venda');
        $statement->execute([
            'id_venda' => $id_venda
        ]);
    }
}