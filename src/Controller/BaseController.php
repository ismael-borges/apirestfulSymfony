<?php

namespace App\Controller;

use App\Helper\EntidadeFactory;
use App\Helper\ExtratorDadosRequest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends AbstractController
{
    protected ObjectRepository $repository;
    protected EntityManagerInterface $entityManager;
    protected EntidadeFactory $factory;
    private ExtratorDadosRequest $extratorDadosRequest;

    public function __construct(
        ObjectRepository $repository,
        EntityManagerInterface $entityManager,
        EntidadeFactory $factory,
        ExtratorDadosRequest $extratorDadosRequest
    ) {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->factory = $factory;
        $this->extratorDadosRequest = $extratorDadosRequest;
    }

    abstract function atualizarEntity($content, $entity);

    public function novo(Request $request): Response
    {
        $entity = $this->factory->criarEntidade($request->getContent());
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return new JsonResponse($entity);
    }

    public function atualizar(int $id, Request $request): Response
    {
        $content = $this->factory->criarEntidade($request->getContent());
        $entity = $this->repository->find($id);

        if (is_null($entity)) {
            return new Response("", Response::HTTP_NOT_FOUND);
        }

        $this->atualizarEntity($content, $entity);
        $this->entityManager->flush();
        return new JsonResponse($entity);
    }

    public function buscarTodos(Request $request): Response
    {
        return new JsonResponse(
            $this->repository->findBy(
                $this->extratorDadosRequest->getDataFilter($request),
                $this->extratorDadosRequest->getDataSort($request),
            )
        );
    }

    public function buscarUm(int $id): Response
    {
        return new JsonResponse($this->repository->find($id));
    }

    public function remove(int $id): Response
    {
        $this->entityManager->remove($this->repository->find($id));
        $this->entityManager->flush();
        return new JsonResponse('', Response::HTTP_NO_CONTENT);
    }
}