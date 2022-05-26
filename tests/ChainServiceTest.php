<?php

namespace App\Tests;

use App\Service\ChainService;
use PHPUnit\Framework\TestCase;

class ChainServiceTest extends TestCase
{
    const CHAIN = [
        'aaaopkln' => ['length' => 3, 'char' => 'a'],
        'azertyyyyyyoo' => ['length' => 6, 'char' => 'y'],
        'gdgnkgnhfkhtrbppppppppiu' => ['length' => 8, 'char' => 'p'],
    ];

    public function testGetGreatestOccurrence()
    {
        $chainService = new ChainService();

        foreach (self::CHAIN as $key => $item) {
            $response = $chainService->getGreatestOccurrence($key);

            $this->assertSame($response, $item);
        }
    }
}