<?php

namespace App\Model;

final class ClienteModel
{
    /**
     * @var int
     */
    private $id_cliente;
    /**
     * @var string
     */
    private $nome;
    /**
     * @var string
     */
    private $cpf;
    /**
     * @var string
     */
    private $telefone;
    /**
     * @var string
     */
    private $endereco;

    /**
     * @return int
     */
    public function getId_cliente(): int
    {
        return $this->id_cliente;
    }

     /**
     * @param int $id_cliente
     * @return ClienteModel
     */
    public function setId_cliente(string $id_cliente): ClienteModel
    {
        $this->id_cliente = $id_cliente;
        return $this;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string
     * @return ClienteModel
     */
    public function setNome(string $nome): ClienteModel
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return string
     */
    public function getCpf(): string
    {
        return $this->cpf;
    }

    /**
     * @param string
     * @return ClienteModel
     */
    public function setCpf(string $cpf): ClienteModel
    {
        $this->cpf = $cpf;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelefone(): string
    {
        return $this->telefone;
    }

    /**
     * @param string
     * @return ClienteModel
     */
    public function setTelefone(string $telefone): ClienteModel
    {
        $this->telefone = $telefone;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndereco(): string
    {
        return $this->endereco;
    }

    /**
     * @param string
     * @return ClienteModel
     */
    public function setEndereco(string $endereco): ClienteModel
    {
        $this->endereco = $endereco;
        return $this;
    }
}