<?php

declare(strict_types=1);

namespace ZakDevCode\GraphHandler\Graph;

class UndirectedGraph
{
    private array $graph = [];

    public function getAdjacencyListRepresentation(): array
    {
        return $this->graph;
    }

    public function addNode(Node $node): self
    {
        if (!array_key_exists($node->getName(), $this->graph)) {
            $this->graph[$node->getName()] = [];
        }
        return $this;
    }

    public function hasNodes(Node ...$nodes): bool
    {
        foreach ($nodes as $node) {
            if (!$this->hasNode($node)) {
                return false;
            }
        }

        return true;
    }

    public function hasNode(Node $node): bool
    {
        return array_key_exists($node->getName(), $this->graph);
    }

    public function addAdjacentNodes(Node $node, Node ...$adjacentNodes): self
    {
        $adjacencyList = $this->getAdjacencyList($node);
        foreach ($adjacentNodes as $adjacentNode) {
            foreach ($adjacencyList as $existsNode) {
                if ($adjacentNode->isEqual($existsNode)) {
                    continue 2;
                }
            }
            $adjacencyList[] = $adjacentNode;
        }
        $this->graph[$node->getName()] = $adjacencyList;

        foreach ($adjacentNodes as $adjacentNode) {
            $adjacencyList = $this->getAdjacencyList($adjacentNode);
            foreach ($adjacencyList as $existsNode) {
                if ($node->isEqual($existsNode)) {
                    continue 2;
                }
            }
            $adjacencyList[] = $node;
            $this->graph[$adjacentNode->getName()] = $adjacencyList;
        }

        return $this;
    }

    /**
     * @return Node[]
     */
    public function getAdjacencyList(Node $node): array
    {
        return $this->graph[$node->getName()] ?? [];
    }
}