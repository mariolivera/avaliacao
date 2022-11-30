<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Curso;
use App\Notification\WebNotification;
use App\Repository\CategoriaRepository;
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
        $this->checkLogin();
        $rep = new CursoRepository();
        $cursos = $rep->buscarTodos();

        $this->render("curso/listar", [
            'cursos' => $cursos,
        ]);
    }

    public function cadastrar(): void
    {

        $rep = new CategoriaRepository();
        if (true === empty($_POST)) {
            $categorias = $rep->buscarTodos();
            $this->render("/curso/cadastrar", ['categorias' => $categorias]);
            return;
        }

        $curso = new Curso();
        $curso->nome = $_POST['nome'];
        $curso->cargaHoraria = intval($_POST['cargaHoraria']);
        $curso->descricao = $_POST['descricao'];
        $curso->categoria_id = intval($_POST['categoria']);

        $this->repository->inserir($curso);
        // try {
        // } catch (Exception $exception) {
        //     var_dump($exception->getMessage());
        //     // if (true === str_contains($exception->getMessage(), 'cpf')) {
        //     //     die('CPF ja existe');
        //     // }

        //     // if (true === str_contains($exception->getMessage(), 'email')) {
        //     //     die('Email ja existe');
        //     // }

        //     die('Vish, aconteceu um erro');
        // }
        WebNotification::add('Curso cadastrado com sucesso', 'success');
        $this->redirect('/cursos/listar');
    }

    public function excluir(): void
    {
        $id = $_GET['id'];

        $this->repository->excluir($id);

        WebNotification::add('Curso excluido com sucesso, ou não, pq tu sabe sem curso, vai pegar na enchada', 'danger');
        $this->redirect('/cursos/listar');
    }

    public function editar(): void
    {
        $id = $_GET['id'];
        $rep = new CategoriaRepository();
        $categorias = $rep->buscarTodos();
        $curso = $this->repository->buscarUm($id);
        $this->render("/curso/editar", [
            'categorias' => $categorias,
            'curso' => $curso
        ]);
        if (false === empty($_POST)) {
            $curso = new Curso();
            $curso->nome = $_POST['nome'];
            $curso->cargaHoraria = intval($_POST['cargaHoraria']);
            $curso->descricao = $_POST['descricao'];
            $curso->categoria_id = intval($_POST['categoria']);
            $this->repository->atualizar($curso, $id);
            WebNotification::add('Curso editado com sucesso', 'success');
            $this->redirect('/cursos/listar');
        }
    }
}
