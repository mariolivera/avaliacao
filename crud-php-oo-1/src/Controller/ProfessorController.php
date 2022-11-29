<?php

declare(strict_types=1);

namespace App\Controller;
use App\model\Professor;
use App\Repository\ProfessorRepository;
use Exception;

class ProfessorController extends AbstractController
{
    private ProfessorRepository $repository;
    // public const REPOSITORY = new ProfessorRepository();
    public function __construct()
    {
        $this->repository = new ProfessorRepository();
    }
    public function listar(): void
    {
        //$rep = new ProfessorRepository();
        $professores = $this->repository->buscarTodos();

        $this->render("professor/listar", [
            'professores' => $professores,
        ]);
    }

    public function cadastrar(): void
    {
        if (true === empty($_POST)) {
            $this->render('professor/cadastrar');
            return;
        }
        $professor = new Professor();
        $professor->nome = $_POST['nome'];
        $professor->endereco = $_POST['endereco'];
        $professor->formacao = $_POST['formacao'];
        $professor->status = $_POST['status'];
        $professor->cpf = $_POST['cpf'];
        try{
            $this->repository->inserir($professor);
        } catch (Exception $exception) {
            if (true === str_contains($exception->getMessage(), 'cpf')){
                die('CPF já existe');
            }
            if(true === str_contains($exception->getMessage(), 'email')){
                die('Email ja existe');
            }
            die('ocorreu um erro');
        }
        $this->redirect('/professores/listar');
    }

    public function excluir(): void
    {
        $id = $_GET['id'];
        $this->repository->excluir($id);
        $this->redirect('/professores/listar');
    }

    public function editar(): void
    {
        $id = $_GET['id'];
        $rep = new ProfessorRepository();
        $professor = $rep->buscarUm($id);
        $this->render('professor/editar', [$professor]);
        if (false === empty($_POST)){
            $professor->nome = $_POST['nome'];
            $professor->endereco = $_POST['endereco'];
            $professor->formacao = $_POST['formacao'];
            $professor->status = $_POST['status'];
            $professor->CPF = $_POST['CPF'];

            try {
                $rep->atualizar($professor, $id);
            } catch (Exception $exception) {
                if(true === str_contains($exception->getMessage(), 'cpf')){
                    die('CPF já existe');
                }
                if (true === str_contains($exception->getMessage(), 'email')){
                    die('Email já existe');
                }
                die('Ocorreu um erro, vamos resolver');
            }
            $this->redirect('/professores/listar');
        }
    }
}