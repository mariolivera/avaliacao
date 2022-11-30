<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Professor;
use App\Notification\WebNotification;
use App\Repository\ProfessorRepository;
use Exception;

class ProfessorController extends AbstractController
{
    // public const REPOSITORY = new ProfessorRepository();
    private ProfessorRepository $repository;

    public function __construct()
    {
        $this->repository = new ProfessorRepository();
    }

    public function listar(): void
    {
        //$rep = new ProfessorRepository();
        //$professores = $rep->buscarTodos();
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
        $professor->cpf = $_POST['cpf'];
        try {
            $this->repository->inserir($professor);
        } catch (Exception $exception){
            if (true === str_contains($exception->getMessage(), 'cpf')){
                die ('cpf já existente');
            }
            die('Error, estamos trabalhando no problema');
        }
        WebNotification::add('Professor cadastrado', 'success');
        $this->redirect('/professores/listar');
    }

    public function excluir(): void
    {
        $id = $_GET['id'];
        //$rep = new ProfessorRepository();
        //$rep->excluir($id);
        $this->repository->excluir($id);
        WebNotification::add('professor excluido com sucesso, mó paia excluiram o proffesor, diabo é isso alé', 'danger');
        $this->redirect("/professores/listar");
    }

    public function editar(): void
    {
        $this->checkLogin();
        $id = $_GET['id'];
        $rep = new ProfessorRepository();
        $professor = $rep->buscarUm($id);
        $this->render('professor/editar', [$professor]);
        if (false === empty($_POST)) {
            $professor->nome = $_POST['nome'];
            $professor->cpf = $_POST['cpf'];
            
            try {
                $rep->atualizar($professor, $id);
            } catch (Exception $exception) {
                if (true === str_contains($exception->getMessage(), 'cpf')) {
                    die('CPF ja existe');
                }
                die('Vish, aconteceu um erro');
            }

            WebNotification::add('professor editado com sucesso', 'success');
            $this->redirect('/professores/listar');
        }
    }
}
