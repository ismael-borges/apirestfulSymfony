<?php

namespace App\Helper;

use App\Entity\Especialidade;

class EspecialidadeFactory implements EntidadeFactory
{
    public function criarEntidade(string $json): Especialidade
    {
        $dadosEmJson = json_decode($json);
        $this->checkAllProperties($dadosEmJson);
        $especialidade = new Especialidade();
        $especialidade->setDescricao($dadosEmJson->descricao);
        return $especialidade;
    }

    private function checkAllProperties(object $dadosEmJson): void
    {
        if (!property_exists($dadosEmJson, 'descricao')) {
            throw new EntityFactoryException('Parâmetro incorreto!');
        }
    }
}