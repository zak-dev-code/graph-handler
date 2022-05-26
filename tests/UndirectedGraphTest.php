<?php

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;
use ZakDevCode\GraphHandler\Graph\Node;
use ZakDevCode\GraphHandler\Graph\UndirectedGraph;

class UndirectedGraphTest extends TestCase
{
    public function testEmptyUndirectedGraphCreate(): void
    {
        $graph = new UndirectedGraph();

        $this->assertEquals([], $graph->getAdjacencyListRepresentation());
        $this->assertEquals([], $graph->getAdjacencyList(new Node('test')));
        $this->assertFalse($graph->hasNode(new Node('test')));
        $this->assertFalse($graph->hasNodes(new Node('testOne'), new Node('testTwo')));
    }

    public function testUndirectedGraphFill(): void
    {
        $graph = new UndirectedGraph();

        $newNodeOne = new Node('first');
        $graph->addNode($newNodeOne);

        $this->assertTrue($graph->hasNode($newNodeOne));
        $this->assertTrue($graph->hasNodes($newNodeOne));
        $this->assertEquals([], $graph->getAdjacencyList($newNodeOne));
        $this->assertEquals([$newNodeOne->getName() => []], $graph->getAdjacencyListRepresentation());

        $newNodeTwo = new Node('second');
        $graph->addAdjacentNodes($newNodeOne, $newNodeTwo);

        $this->assertTrue($graph->hasNode($newNodeTwo));
        $this->assertTrue($graph->hasNodes($newNodeTwo));
        $this->assertEquals([$newNodeTwo], $graph->getAdjacencyList($newNodeOne));
        $this->assertEquals([$newNodeOne], $graph->getAdjacencyList($newNodeTwo));
        $this->assertEquals(
            [
                $newNodeOne->getName() => [$newNodeTwo],
                $newNodeTwo->getName() => [$newNodeOne],
            ],
            $graph->getAdjacencyListRepresentation()
        );
    }
}