<?php

namespace App\Helper;

use App\Entity\Medico;
use App\Repository\EspecialidadeRepository;

class MedicoFactory implements EntidadeFactory
{
    private EspecialidadeRepository $especialidadeRepository;

    public function __construct(EspecialidadeRepository $especialidadeRepository)
    {
        $this->especialidadeRepository = $especialidadeRepository;
    }

    public function criarEntidade(string $json): Medico
    {
        $data = json_decode($json);
        $this->checkAllProperties($data);
        $medico = new Medico();
        $medico->setCrm($data->crm)
            ->setNome($data->nome)
            ->setEspecialidade(
                $this->especialidadeRepository->find($data->especialidadeId)
            );
        return $medico;
    }

    private function checkAllProperties(object $data): void
    {
        if (!property_exists($data, 'nome')
            || !property_exists($data, 'crm')
            || !property_exists($data, 'especialidadeId')) {
            throw new EntityFactoryException('Parâmetro incorreto!');
        }
    }
}