<?php
require __DIR__.'/../vendor/autoload.php';

use App\Model\Vaga;

$vagas = new Vaga();
$results = $vagas->listAll();


foreach ($results as $result) {
    echo "{$result['titulo']} -  Área: {$result['area']} - Salário {$result['salario']} <br>
          Descrição: {$result['descricao']}";
}
