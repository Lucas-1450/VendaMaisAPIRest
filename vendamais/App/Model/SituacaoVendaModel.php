<?php

namespace App\Model;

final class SituacaoVendaModel
{
    /**
     * @var int
     */
    private $id_situacao;
    /**
     * @var string
     */
    private $descricao_situacao;

    /**
     * @return int
     */
    public function getId_situacao(): int
    {
        return $this->id_situacao;
    }

       /**
     * @param int $id_situacao
     * @return SituacaoVendaModel
     */
    public function setId_situacao(string $id_situacao): SituacaoVendaModel
    {
        $this->id_situacao = $id_situacao;
        return $this;
    }

    /**
     * @return string
     */
    public function getdescricao_situacao(): string
    {
        return $this->descricao_situacao;
    }

    /**
     * @param string
     * @return SituacaoVendaModel
     */
    public function setdescricao_situacao(string $descricao_situacao): SituacaoVendaModel
    {
        $this->descricao_situacao = $descricao_situacao;
        return $this;
    }
}