<?php

namespace App\Model;

final class ProdutoModel
{
    /**
     * @var int
     */
    private $id_produto;
    /**
     * @var string
     */
    private $descricao_produto;
    /**
     * @var float
     */
    private $preco;
    /**
     * @var int
     */
    private $qtd_stq;

    /**
     * @return int
     */
    public function getId_produto(): int
    {
        return $this->id_produto;
    }

    /**
     * @param int
     * @return ProdutoModel
     */
    public function setId_produto(int $id_produto): ProdutoModel
    {
        $this->id_produto = $id_produto;
        return $this;
    }

    /**
     * @return string
     */
    public function getdescricao_produto(): string
    {
        return $this->descricao_produto;
    }

    /**
     * @param string
     * @return ProdutoModel
     */
    public function setdescricao_produto(string $descricao_produto): ProdutoModel
    {
        $this->descricao_produto = $descricao_produto;
        return $this;
    }

    /**
     * @return float
     */
    public function getPreco(): float
    {
        return $this->preco;
    }

    /**
     * @param float
     * @return ProdutoModel
     */
    public function setPreco(float $preco): ProdutoModel
    {
        $this->preco = $preco;
        return $this;
    }

    /**
     * @return int
     */
    public function getQtdStq(): int
    {
        return $this->qtd_stq;
    }

    /**
     * @param int
     * @return ProdutoModel
     */
    public function setQtdStq(int $qtd_stq): ProdutoModel
    {
        $this->qtd_stq = $qtd_stq;
        return $this;
    }
}