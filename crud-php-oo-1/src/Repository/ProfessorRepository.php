<?php

declare(strict_types=1);

namespace App\Repository;

use App\Connection\DatabaseConnection;
use App\Model\Professor;
use PDO;

class ProfessorRepository implements RepositoryInterface
{

    public const TABLE = "tb_professor"; // na digital coleger usa o banco de dados de professores como |professor|

    public PDO $pdo;

    public function __construct()
    {
        $this->pdo = DatabaseConnection::abrirConexao();
    }

    public function buscarTodos(): iterable
    {
        //$conexao = DatabaseConnection::abrirConexao();

        $sql = "SELECT * FROM " . self::TABLE;

        $query = $this->pdo->query($sql);

        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS, Professor::class);
    }

    public function buscarUm(string $id): ?object
    {
        $sql = "SELECT * FROM ".self::TABLE." WHERE id = '{$id}'";
        $query = $this->pdo->query($sql);
        $query->execute();
        return $query->fetchObject(Professor::class);
    }

    public function inserir(object $dados): object
    {
        $sql = "INSERT INTO ". self::TABLE .
        "( endereço, formacao, status, nome, cpf)" .
            "VALUE (
                '{$dados->endereco}',
                '{$dados->formacao}',
                '{$dados->status}',
                '{$dados->nome}',
                '{$dados->cpf}',
            );";
            $this->pdo->query($sql);

        return $dados;
    } 

    public function atualizar(object $novosdados, string $id): object
    {
        $sql = "UPDDATE " . self::TABLE . 
        "SET
            endereco='{$novosdados->endereco}',
            formacao='{$novosdados->formacao}',
            status='{$novosdados->status}',
            nome='{$novosdados->nome}',
            cpf='{$novosdados->cpf}',
        WHERE id = {$id}';";
        $this->pdo->query($sql);
        return $novosdados;
    }

    public function excluir(string $id): void
    {
        //$conexao = DatabaseConnection::abrirConexao();
        $sql = "DELETE FROM ".self::TABLE." WHERE id = '{$id}'";
        $query = $this->pdo->query($sql);
        $query->execute();
    }
}