<?php

namespace App\Controller;

use App\Service\ChainService;
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
     *     path = "/",
     *     name = "api_calculate_occurrence",
     *     requirements = {"chain"="[a-zA-Z]+"}
     * )
     *
     * @QueryParam(name="chain", requirements="[a-zA-Z]+", strict=true, description="The chain")
     */
    public function calculateOccurrenceAction(string $chain, CacheInterface $cache)
    {
        $response = $cache->get(md5($chain), function() use ($chain){
            return $this->chainService->getGreatestOccurrence($chain);
        });

        $view = $this->view($response, 200);

        return $this->handleView($view);
    }
}