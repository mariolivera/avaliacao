<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Curso;
use App\Repository\CursoRepository;
use Exception;

class CursoController extends AbstractController
{
    private CursoRepository $repository;

    public function __construct()
    {
        $this->repository = new CursoRepository();
    }

    public function listar(): void
    {
        $cursos = $this->repository->buscarTodos();
        $this->render('curso/listar', [
            'cursos' => $cursos,
        ]);
    }

    public function cadastrar(): void
    {
        if (true === empty($_POST)) {
            $this->render('curso/cadastras');
            return;
        }
        $curso = new Curso();
        $curso->nome = $_POST['nome'];
        $curso->periodo = $_POST['periodo'];
        $curso->professor = $_POST['professor'];
        $curso->laboratorio = $_POST['laboratorio'];

        $this->redirect('/cursos/listar');
    }


    public function editar(): void
    {
        $id = $_GET['id'];
        $rep = new CursoRepository();
        $curso = $rep->buscarUm($id);
        $this->render('curso/editar', [$curso]);
        if (false === empty($_POST)) {
            $curso->nome = $_POST['nome'];
            $curso->periodo = $_POST['periodo'];
            $curso->professor = $_POST['professor'];
            $curso->laboratorio = $_POST['laboratorio'];
        }
        $this->redirect('/cursos/listar');
    }

    public function excluir(): void
    {
        $id = $_GET['id'];
        $this->repository->excluir($id);
        $this->redirect('/cursos/listar');
    }
}
