<?php

declare(strict_types=1);

namespace App\Model;

class Professor extends Pessoa
{
    public string $endereco;
    public string $formacao;
    public string $status;
    // public string $nome;
    // public string $cpf;
    //public array $horariosDisponiveis = [];
}
