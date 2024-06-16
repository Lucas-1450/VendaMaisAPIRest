<?php

namespace App\DAO;

use App\Model\VendaItemModel;

class VendaItemDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getItem(): array
    {
        $venda_item = $this->pdo
            ->query('SELECT
                    id_venda,
                    item,
                    id_produto,
                    desc_produto,
                    qtd_produto,
                    vr_unitario,
                    vr_total
                    FROM venda_item
                    ORDER BY item;')
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $venda_item;
        
    }

    public function getItemByID(int $id_venda, int $item): array
    {
        $statement = $this->pdo
            ->prepare('SELECT
                        i.id_venda,
                        i.item,
                        i.id_produto,
                        p.descricao_produto AS desc_produto,
                        i.qtd_produto,
                        i.vr_unitario,
                        i.vr_total
                        FROM venda_item i
                        JOIN produto p ON p.id_produto = i.id_produto
                        WHERE i.id_venda = :id_venda
                        AND i.item = :item');
        $statement->bindParam('id_venda', $id_venda, \PDO::PARAM_INT);
        $statement->bindParam('item', $item, \PDO::PARAM_INT);
        $statement->execute();
        $venda_item = $statement->fetch(\PDO::FETCH_ASSOC);

        return $venda_item ?: null;
    }

    public function getItensVenda(int $id_venda): array
    {
        $statement = $this->pdo
            ->prepare('SELECT
            id_venda,
            item,
            id_produto,
            desc_produto,
            qtd_produto,
            vr_unitario,
            vr_total
            FROM venda_item
            WHERE id_venda = :id_venda');
        $statement->bindParam('id_venda', $id_venda, \PDO::PARAM_INT);
        $statement->execute();
        $venda = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $venda ?: [];
    }

    public function getLastInsertedId(int $id_venda): int
    {
        $statement = $this->pdo
            ->prepare('SELECT COALESCE(MAX(item), 0) AS max_id FROM venda_item WHERE id_venda = :id_venda');
        $statement->bindValue('id_venda', $id_venda, \PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        return $result['max_id'];
    }

    public function insertVendaItem(VendaItemModel $venda_item): void
    {
        $id_venda = $venda_item->getIdVenda();
        $id_aux = $this->getLastInsertedId($id_venda);
        $nextId = $id_aux + 1;


        $statement = $this->pdo
            ->prepare('INSERT INTO venda_item VALUES(
                :id_venda,
                :item,
                :id_produto,
                :desc_produto,
                :qtd_produto,
                :vr_unitario,
                :vr_total
            );');
        
        $statement->execute([
            'id_venda' => $venda_item->getIdVenda(),
            'item' => $nextId,
            'id_produto' => $venda_item->getIdProduto(),
            'desc_produto' => $venda_item->getDescProduto(),
            'qtd_produto' => $venda_item->getQtdProduto(),
            'vr_unitario' => $venda_item->getVrUnit(),
            'vr_total' => $venda_item->getVrTotal(),
        ]);

    }

    public function updateVendaItem(VendaItemModel $venda_item): void
    {

        $item = $venda_item->getItem();

        $statement = $this->pdo->prepare('UPDATE venda_item SET 
            id_venda = :id_venda,
            item = :item,
            id_produto = :id_produto,
            desc_produto = :desc_produto,
            qtd_produto = :qtd_produto, 
            vr_unitario = :vr_unitario, 
            vr_total = :vr_total 
            WHERE id_venda = :id_venda AND item = :item
        ');

        $statement->execute([
            'id_venda' => $venda_item->getIdVenda(),
            'item' => $item,
            'id_produto' => $venda_item->getIdProduto(),
            'desc_produto' => $venda_item->getDescProduto(),
            'qtd_produto' => $venda_item->getQtdProduto(),
            'vr_unitario' => $venda_item->getVrUnit(),
            'vr_total' => $venda_item->getVrTotal()
        ]);
    }

    public function deleteVendaItem(VendaItemModel $venda_item): void
    {

        $item = $venda_item->getItem();

        $statement = $this->pdo
            ->prepare('DELETE FROM venda_item WHERE item = :item AND id_venda = :id_venda');
        $statement->execute([
            'id_venda' => $venda_item->getIdVenda(),
            'item' => $item
        ]);
    }

    public function getProdutosVenda(int $id_venda): array
    {
        $statement = $this->pdo
            ->prepare('SELECT id_produto, qtd_produto FROM venda_item WHERE id_venda = :id_venda');
        $statement->bindValue(':id_venda', $id_venda, \PDO::PARAM_INT);
        $statement->execute();
        $itens = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $itens ?: [];
    }

    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    public function commit()
    {
        $this->pdo->commit();
    }

    public function rollBack()
    {
        $this->pdo->rollBack();
    }
}