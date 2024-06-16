<?php

namespace App\Model;

final class VendaModel
{
    /**
     * @var int
     */
    private $id_venda;
    /**
     * @var string
     */
    private $dt_venda;
    /**
     * @var int
     */
    private $id_cliente;
    /**
     * @var string
     */
    private $vr_total;
    /**
     * @var string
     */
    private $vr_frete;
    /**
     * @var string
     */
    private $desconto;
    /**
     * @var int
     */
    private $situacao;
    /**
     * @var int
     */
    private $formapg;

    /**
     * @return int
     */
    public function getId_venda(): int
    {
        return $this->id_venda;
    }

     /**
     * @param int $id_venda
     * @return VendaModel
     */
    public function setId_venda(string $id_venda): VendaModel
    {
        $this->id_venda = $id_venda;
        return $this;
    }

    /**
     * @return string
     */
    public function getDtVenda(): string
    {
        return $this->dt_venda;
    }

    /**
     * @param string
     * @return VendaModel
     */
    public function setDtVenda(string $dt_venda): VendaModel
    {
        $this->dt_venda = $dt_venda;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdCliente():int
    {
        return $this->id_cliente;
    }


    /**
     * @param int
     * @return VendaModel
     */
    public function setIdCliente(int $id_cliente): VendaModel
    {
        $this->id_cliente = $id_cliente;
        return $this;
    }

    /**
     * @return string
     */
    public function getVrTotal():string
    {
        return $this->vr_total;
    }

    /**
     * @param string
     * @return VendaModel
     */
    public function setVrTotal(string $vr_total): VendaModel
    {
        $this->vr_total = $vr_total;
        return $this;
    }

    /**
     * @return string
     */
    public function getVrFrete():string
    {
        return $this->vr_frete;
    }

    /**
     * @param string
     * @return VendaModel
     */
    public function setVrFrete(string $vr_frete): VendaModel
    {
        $this->vr_frete = $vr_frete;
        return $this;
    }

    /**
     * @return string
     */
    public function getDesconto():string
    {
        return $this->desconto;
    }

    /**
     * @param string
     * @return VendaModel
     */
    public function setDesconto(string $desconto): VendaModel
    {
        $this->desconto = $desconto;
        return $this;
    }

    /**
     * @return int
     */
    public function getSituacao():int
    {
        return $this->situacao;
    }


    /**
     * @param int
     * @return VendaModel
     */
    public function setSituacao(int $situacao): VendaModel
    {
        $this->situacao = $situacao;
        return $this;
    }

    /**
     * @return int
     */
    public function getFormaPg():int
    {
        return $this->formapg;
    }


    /**
     * @param int
     * @return VendaModel
     */
    public function setFormaPg(int $formapg): VendaModel
    {
        $this->formapg = $formapg;
        return $this;
    }


}