<?php

declare(strict_types=1);

namespace App\Controller;

use App\Notification\WebNotification;
use App\Repository\ProfessorRepository;
use Exception;

class ProfessorController extends AbstractController
{
    // public const REPOSITORY = new ProfessorRepository();

    public function listar(): void
    {
        $rep = new ProfessorRepository();
        $professores = $rep->buscarTodos();

        $this->render("professor/listar", [
            'professores' => $professores,
        ]);
    }

    public function cadastrar(): void
    {
        echo "Pagina de cadastrar";
    }

    public function excluir(): void
    {
        $id = $_GET['id'];
        $rep = new ProfessorRepository();
        $rep->excluir($id);
        WebNotification::add('Aluno excluido com sucesso', 'danger');
        $this->redirect("/professores/listar");
    }

    public function editar(): void
    {
        $this->checkLogin();
        $id = $_GET['id'];
        $rep = new ProfessorRepository();
        $aluno = $rep->buscarUm($id);
        $this->render('aluno/editar', [$aluno]);
        if (false === empty($_POST)) {
            $aluno->nome = $_POST['nome'];
            $aluno->dataNascimento = $_POST['nascimento'];
            $aluno->cpf = $_POST['cpf'];
            $aluno->email = $_POST['email'];
            $aluno->genero = $_POST['genero'];

            try {
                $rep->atualizar($aluno, $id);
            } catch (Exception $exception) {
                if (true === str_contains($exception->getMessage(), 'cpf')) {
                    die('CPF ja existe');
                }

                if (true === str_contains($exception->getMessage(), 'email')) {
                    die('Email ja existe');
                }

                die('Vish, aconteceu um erro');
            }

            WebNotification::add('professor editado com sucesso', 'success');
            $this->redirect('/professores/listar');
        }
    }
}
