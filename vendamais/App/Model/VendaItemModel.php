<?php

namespace App\Model;

final class VendaItemModel
{
    /**
     * @var int
     */
    private $id_venda;
    /**
     * @var int
     */
    private $item;
    /**
     * @var int
     */
    private $id_produto;
    /**
     * @var string
     */
    private $desc_produto;
    /**
     * @var int
     */
    private $qtd_produto;
    /**
     * @var float
     */
    private $vr_unitario;
    /**
     * @var float
     */
    private $vr_total;

    /**
     * @return int
     */
    public function getIdVenda(): int
    {
        return $this->id_venda;
    }

    /**
     * @param int
     * @return VendaItemModel
     */
    public function setIdVenda(int $id_venda): VendaItemModel
    {
        $this->id_venda = $id_venda;
        return $this;
    }
    /**
     * @return int
     */
    public function getItem(): int
    {
        return $this->item;
    }

     /**
     * @param int 
     * @return VendaItemModel
     */
    public function setItem(string $item): VendaItemModel
    {
        $this->item = $item;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdProduto():int
    {
        return $this->id_produto;
    }


    /**
     * @param int
     * @return VendaItemModel
     */
    public function setIdProduto(int $id_produto): VendaItemModel
    {
        $this->id_produto = $id_produto;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescProduto(): string
    {
        return $this->desc_produto;
    }

    /**
     * @param string
     * @return VendaItemModel
     */
    public function setDescProduto(string $desc_produto): VendaItemModel
    {
        $this->desc_produto = $desc_produto;
        return $this;
    }

    /**
     * @return int
     */
    public function getQtdProduto(): int
    {
        return $this->qtd_produto;
    }

    /**
     * @param int
     * @return VendaItemModel
     */
    public function setQtdProduto(int $qtd_produto): VendaItemModel
    {
        $this->qtd_produto = $qtd_produto;
        return $this;
    }

    /**
     * @return float
     */
    public function getVrUnit(): float
    {
        return $this->vr_unitario;
    }

    /**
     * @param float
     * @return VendaItemModel
     */
    public function setVrUnit(float $vr_unitario): VendaItemModel
    {
        $this->vr_unitario = $vr_unitario;
        return $this;
    }

    /**
     * @return float
     */
    public function getVrTotal(): float
    {
        return $this->vr_total;
    }


    /**
     * @param float
     * @return VendaItemModel
     */
    public function setVrTotal(float $vr_total): VendaItemModel
    {
        $this->vr_total = $vr_total;
        return $this;
    }

}