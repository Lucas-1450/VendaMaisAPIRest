<?php

namespace App\Model;

final class FormaPgModel
{
    /**
     * @var int
     */
    private $id_forma;
    /**
     * @var string
     */
    private $descricao_forma;

    /**
     * @return int
     */
    public function getId_forma(): int
    {
        return $this->id_forma;
    }

    /**
     * @param int
     * @return FormaPgModel
     */
    public function setId_forma(int $id_forma): FormaPgModel
    {
        $this->id_forma = $id_forma;
        return $this;
    }

    /**
     * @return string
     */
    public function getdescricao_forma(): string
    {
        return $this->descricao_forma;
    }

    /**
     * @param string
     * @return FormaPgModel
     */
    public function setdescricao_forma(string $descricao_forma): FormaPgModel
    {
        $this->descricao_forma = $descricao_forma;
        return $this;
    }
}