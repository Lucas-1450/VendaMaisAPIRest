<?php

namespace App\DAO;

use App\Model\UsuarioModel;

class UsuarioDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllUsuarios(): array
    {
        $usuario = $this->pdo
            ->query('SELECT
                    id_usuario,
                    usuario,
                    senha
                    FROM usuario;')
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $usuario;
    }

    public function getLastInsertedId_usuario(): int
    {
        $statement = $this->pdo
            ->query('SELECT COALESCE(MAX(id_usuario), 0) AS max_id_usuario FROM usuario');
        $result = $statement
            ->fetch(\PDO::FETCH_ASSOC);

        return $result['max_id_usuario'];
    }

    public function insertUsuario(UsuarioModel $usuario): bool
    {

        $checkQuery = 'SELECT COUNT(*) FROM usuario WHERE usuario = :usuario';
        $checkStatement = $this->pdo->prepare($checkQuery);        
        $checkStatement->execute(['usuario' => $usuario->getUsuario()]);
        $usuarioExists = (bool)$checkStatement->fetchColumn();

        if ($usuarioExists) {

            return false;
        }

        $id_usuario_aux = $this->getLastInsertedId_usuario();
        $nextid_usuario = $id_usuario_aux + 1;


        $statement = $this->pdo
            ->prepare('INSERT INTO usuario VALUES(
                :id_usuario,
                :usuario,
                :senha
            );');
        
        $statement->execute([
            'id_usuario' => $nextid_usuario,
            'usuario' => $usuario->getUsuario(),
            'senha' => $usuario->getSenha()
        ]);

        return true; 

    }

    public function updateUsuario(UsuarioModel $usuario): void
    {

        $id_usuario = $usuario->getId_usuario();

        $statement = $this->pdo->prepare('UPDATE usuario SET 
            usuario = :usuario,
            senha = :senha
            WHERE id_usuario = :id_usuario
        ');

        $statement->execute([
            'id_usuario' => $id_usuario,
            'usuario' => $usuario->getUsuario(),
            'senha' => $usuario->getSenha()
        ]);
    }

    public function deleteUsuario(UsuarioModel $usuario): void
    {

        $id_usuario = $usuario->getId_usuario();

        $statement = $this->pdo
            ->prepare('DELETE FROM usuario WHERE id_usuario = :id_usuario');
        $statement->execute([
            'id_usuario' => $id_usuario
        ]);
    }
}