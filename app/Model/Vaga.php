<?php

namespace App\Model;

class Vaga extends Model
{
    protected $table = 'VAGAS';

    protected $columns = [
        'id',
        'titulo',
        'area',
        'tipo_contrato',
        'salario',
        'descricao',
        'status',
        'data_criacao',
        'data_alteracao'
    ];
}
