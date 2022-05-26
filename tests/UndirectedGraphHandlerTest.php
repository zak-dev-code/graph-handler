<?php

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;
use ZakDevCode\GraphHandler\Graph\Exceptions\PathDoesNotExistException;
use ZakDevCode\GraphHandler\Graph\Node;
use ZakDevCode\GraphHandler\Graph\UndirectedGraph;
use ZakDevCode\GraphHandler\Graph\UndirectedGraphHandler;

class UndirectedGraphHandlerTest extends TestCase
{
    private UndirectedGraph $graph;

    protected function setUp(): void
    {
        parent::setUp();

        $graphList = [
            'A' => ['C', 'F', 'G', 'E'],
            'B' => ['E', 'F', 'G'],
            'C' => ['A', 'D'],
            'D' => ['C', 'G'],
            'E' => ['B', 'A'],
            'F' => ['A', 'B'],
            'G' => ['A', 'B', 'D'],
        ];

        $graph = new UndirectedGraph();

        foreach ($graphList as $node => $adj) {
            $adjNodes = [];
            foreach ($adj as $name) {
                $adjNodes[] = new Node($name);
            }
            $graph->addAdjacentNodes(new Node($node), ...$adjNodes);
        }

        $this->graph = $graph;
    }

    public function testFailBreadthFirstSearch(): void
    {
        $handler = new UndirectedGraphHandler($this->graph);

        $this->expectException(PathDoesNotExistException::class);

        $handler->breadthFirstSearch(new Node('A'), new Node('N'));
    }

    public function testBreadthFirstSearch(): void
    {
        $handler = new UndirectedGraphHandler($this->graph);

        $nodeB = new Node('B');
        $nodeC = new Node('C');

        $resultPath = $handler->breadthFirstSearch($nodeB, $nodeC);

        $this->assertEquals(4, $resultPath->count());
        $this->assertTrue($nodeB->isEqual($resultPath->bottom()));
        $this->assertTrue($nodeC->isEqual($resultPath->top()));

        $nodeD = new Node('D');

        $resultPath = $handler->breadthFirstSearch($nodeD, $nodeB);

        $this->assertEquals(3, $resultPath->count());
        $this->assertTrue($nodeD->isEqual($resultPath->bottom()));
        $this->assertTrue($nodeB->isEqual($resultPath->top()));
    }
}