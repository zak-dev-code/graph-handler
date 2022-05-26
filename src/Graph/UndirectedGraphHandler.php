<?php

declare(strict_types=1);

namespace ZakDevCode\GraphHandler\Graph;

use ZakDevCode\GraphHandler\Graph\Exceptions\PathDoesNotExistException;

class UndirectedGraphHandler
{
    protected UndirectedGraph $graph;

    public function __construct(UndirectedGraph $graph)
    {
        $this->graph = $graph;
    }

    /**
     * @throws PathDoesNotExistException
     */
    public function breadthFirstSearch(Node $origin, Node $destination)
    {
        if (!$this->graph->hasNodes($origin, $destination)) {
            throw new PathDoesNotExistException();
        }

        $visited = [];

        foreach ($this->graph->getAdjacencyListRepresentation() as $nodeName => $adj) {
            $visited[$nodeName] = false;
        }

        $originName = $origin->getName();

        $q = new \SplQueue();
        $q->enqueue($origin);
        $visited[$originName] = true;

        $path = [];
        $path[$originName] = new \SplDoublyLinkedList();
        $path[$originName]->setIteratorMode(\SplDoublyLinkedList::IT_MODE_FIFO|\SplDoublyLinkedList::IT_MODE_KEEP);
        $path[$originName]->push($origin);

        while (!$q->isEmpty() && !$destination->isEqual($q->bottom())) {
            $current = $q->dequeue();

            $adjacencyList = $this->graph->getAdjacencyList($current);
            foreach ($adjacencyList as $adjacentNode) {
                $nodeName = $adjacentNode->getName();
                if (!$visited[$nodeName]) {
                    $q->enqueue($adjacentNode);
                    $visited[$nodeName] = true;

                    $path[$nodeName] = clone $path[$current->getName()];
                    $path[$nodeName]->push($adjacentNode);
                }
            }
        }

        return $path[$destination->getName()] ?? null;
    }
}