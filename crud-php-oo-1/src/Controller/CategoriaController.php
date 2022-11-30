<?php
declare(strict_types=1);
namespace App\Controller;

use App\Model\Categoria;
use Exception;
use App\Repository\CategoriaRepository;


class CategoriaController extends AbstractController
{
    private CategoriaRepository $repository;
    public function __construct()
    {
        $this->repository = new CategoriaRepository();
    }
    public function listar(): void
    {
        $categorias = $this->repository->buscarTodos();
        $this->render('categoria/listar', ['categorias'=>$categorias]);
    }
    public function cadastrar(): void
    {
        if(true === empty($_POST)){
            $this->render('categoria/cadastrar');
            return;
        }
        $categoria = new Categoria();
        $categoria->nome = $_POST['nome'];
        try{
            $this->repository->inserir($categoria);
        } catch(Exception $exception){
            if(true === str_contains($exception->getMessage(), 'nome')){
                die('Categoria já existe');
            }
            
        }
        $this->redirect('/categorias/listar');
    }
    public function editar(): void
    {
        $id = $_GET['id'];
        $categoria = $this->repository->buscarUm($id);
        $this->render('categoria/editar', [$categoria]);
        if(false === empty($_POST)){
            $categoria->nome = $_POST['nome'];
            try{
                $this->repository->atualizar($categoria, $id);
            }catch(Exception $exception){
                if(true === str_contains($exception->getMessage(), 'nome')){
                    die('Categoria já existe');
                }
            }
            $this->redirect('/categorias/listar');
        }
    }
    public function excluir(): void
    {
        $id = $_GET['id'];
        $this->repository->excluir($id);
        $this->render('categoria/excluir');
        $this->redirect('/categorias/listar');
    }
}