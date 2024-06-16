<?php

namespace App\Model;

final class UsuarioModel
{
    /**
     * @var int
     */
    private $id_usuario;
    /**
     * @var string
     */
    private $usuario;
    /**
     * @var string
     */
    private $senha;
    

    /**
     * @return int
     */
    public function getId_usuario(): int
    {
        return $this->id_usuario;
    }

    /**
     * @param int
     * @return UsuarioModel
     */
    public function setId_usuario(int $id_usuario): UsuarioModel
    {
        $this->id_usuario = $id_usuario;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsuario(): string
    {
        return $this->usuario;
    }

    /**
     * @param string
     * @return UsuarioModel
     */
    public function setUsuario(string $usuario): UsuarioModel
    {
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * @return string
     */
    public function getSenha(): string
    {
        return $this->senha;
    }

    /**
     * @param string
     * @return UsuarioModel
     */
    public function setSenha(string $senha): UsuarioModel
    {
        $this->senha = $senha;
        return $this;
    }
}