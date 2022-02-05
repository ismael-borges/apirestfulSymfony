<?php

namespace App\Controller;

use App\Entity\Medico;
use App\Helper\ExtratorDadosRequest;
use App\Helper\MedicoFactory;
use App\Repository\MedicoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicosController extends BaseController
{
    public function __construct(
        EntityManagerInterface $entityManager,
        MedicoFactory $medicoFactory,
        MedicoRepository $medicoRepository,
        ExtratorDadosRequest $extratorDadosRequest
    ) {
        parent::__construct(
            $medicoRepository,
            $entityManager,
            $medicoFactory,
            $extratorDadosRequest
        );
    }

    /**
     * @param Medico $content
     * @param Medico $entity
     */
    public function atualizarEntity($content, $entity)
    {
        $entity
            ->setCrm($content->getCrm())
            ->setNome($content->getNome())
            ->setEspecialidade($content->getEspecialidade());
    }

    #[Route('/especialidades/{especialidadeId}/medicos', methods: 'GET')]
    public function buscaPorEspecialidade(int $especialidadeId): Response
    {
        $medicos = $this->repository->findby([
            "especialidade" => $especialidadeId
        ]);
        $statusHttp = is_null($medicos) ? Response::HTTP_NO_CONTENT : 200;
        return new JsonResponse($medicos, $statusHttp);
    }
}