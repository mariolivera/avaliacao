<?php

declare(strict_types=1);

namespace App\Repository;

use App\Connection\DatabaseConnection;
use App\Model\Curso;
use PDO;

class CursoRepository implements RepositoryInterface
{

    public const TABLE = "tb_curso";

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

        return $query->fetchAll(PDO::FETCH_CLASS, Curso::class);
    }

    public function buscarUm(string $id): ?object
    {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE id = '{$id}'";
        $query = $this->pdo->query($sql);
        $query->execute();
        return $query->fetchObject(Curso::class);
    }

    public function inserir(object $dados): object
    {
        $sql = "INSERT INTO " . self::TABLE .
            "(nome, periodo, professor, laboratorio)" .
            "VALUE (
                '{$dados->nome}',
                '{$dados->periodo}',
                '{$dados->professor}',
                '{$dados->laboratorio}',
            );";
        $this->pdo->query($sql);

        return $dados;
    }

    public function atualizar(object $novosdados, string $id): object
    {
        $sql = "UPDDATE " . self::TABLE .
            "SET
            nome='{$novosdados->nome}',
            periodo='{$novosdados->periodo}',
            professor='{$novosdados->professor}',
            laboratorio='{$novosdados->laboratorio}',
        WHERE id = {$id}';";
        $this->pdo->query($sql);
        return $novosdados;
    }

    public function excluir(string $id): void
    {
        //$conexao = DatabaseConnection::abrirConexao();
        $sql = "DELETE FROM " . self::TABLE . " WHERE id = '{$id}'";
        $query = $this->pdo->query($sql);
        $query->execute();
    }
}
