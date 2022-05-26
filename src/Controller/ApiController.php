<?php

namespace App\Controller;

use App\Entity\Chain;
use App\Service\ChainService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * @Route("/api")
 */
class ApiController extends AbstractFOSRestController
{
    private $chainService;

    public function __construct(ChainService $chainService)
    {
        $this->chainService = $chainService;
    }

    /**
     * @Get(
     *     path = "/calculate-occurrence",
     *     name = "api_calculate_occurrence",
     * )
     *
     * @QueryParam(name="chain", requirements="[a-zA-Z]+", strict=true, description="The chain")
     */
    public function calculateOccurrenceAction(string $chain, CacheInterface $cache, EntityManagerInterface $entityManager)
    {
        $response = $cache->get(md5($chain), function() use ($chain, $entityManager){
            $this->persistChain($chain, $entityManager);

            return $this->chainService->getGreatestOccurrence($chain);
        });

        $view = $this->view($response, 200);

        return $this->handleView($view);
    }

    /**
     * @Get(
     *     path = "/get-occurrence-list",
     *     name = "get_occurrence_list",
     * )
     *
     * @QueryParam(name="page", requirements="\d+", strict=true, default="1", description="page")
     * @QueryParam(name="limit", requirements="\d+", strict=true, default="5", description="limit")
     */
    public function getOccurrenceListAction(EntityManagerInterface $entityManager, int $page, int $limit)
    {
        $response = $entityManager->getRepository(Chain::class)->getPaginatedList($page, $limit);

        $view = $this->view($response, 200);

        return $this->handleView($view);
    }

    /**
     * @param string $chain
     *
     * @return void
     */
    private function persistChain(string $chain, EntityManagerInterface $entityManager): void
    {
        $chainObject = (new Chain())
            ->setText($chain);

        $entityManager->persist($chainObject);

        $entityManager->flush();
    }
}