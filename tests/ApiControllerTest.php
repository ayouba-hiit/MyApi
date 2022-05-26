<?php

namespace App\Tests;

use App\Controller\ApiController;
use App\Repository\ChainRepository;
use App\Service\ChainService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class ApiControllerTest extends TestCase
{
    const LIST = [
        'count' => 15,
        'items' =>
            array (
                0 =>
                    array (
                        'id' => 1,
                        'text' => 'azertyy',
                    ),
                1 =>
                    array (
                        'id' => 2,
                        'text' => 'azertyyppppp',
                    ),
                2 =>
                    array (
                        'id' => 3,
                        'text' => 'azzzzrtyyyyyyyyyuhgfddfg',
                    ),
            ),
    ];

    public function testGetOccurrenceListAction(): void
    {
        $chainRepository = $this->getChainRepository();
        $entityManager = $this->getEntityManager($chainRepository->reveal());
        $chainService = $this->getChainService()->reveal();
        $apiController = new ApiController($chainService);

        $responseList = $apiController->getOccurrenceListAction($entityManager->reveal(), 1,3);

        $this->assertSame($responseList->getData()->getData(), self::LIST);
    }

    /**
     * @return ObjectProphecy
     */
    private function getEntityManager(ChainRepository $chainRepository): ObjectProphecy
    {
        $entityManager = $this->prophesize(EntityManagerInterface::class);

        $entityManager
            ->getRepository(Argument::any())
            ->willReturn($chainRepository);

        return $entityManager;
    }

    /**
     * @return ObjectProphecy
     */
    private function getChainRepository(): ObjectProphecy
    {
        $chainRepository = $this->prophesize(ChainRepository::class);

        $chainRepository
            ->getPaginatedList(Argument::any(), Argument::any())
            ->willReturn(self::LIST)
            ;

        return $chainRepository;
    }

    /**
     * @return ObjectProphecy
     */
    private function getChainService(): ObjectProphecy
    {
        $chainService = $this->prophesize(ChainService::class);

        return $chainService;
    }
}