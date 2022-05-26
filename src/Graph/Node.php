<?php

declare(strict_types=1);

namespace ZakDevCode\GraphHandler\Graph;

class Node
{
    private string $name;

    private array $extraData;

    public function __construct(string $name, array $extraData = [])
    {
        $this->name = $name;
        $this->extraData = $extraData;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getExtraData(): array
    {
        return $this->extraData;
    }

    public function isEqual(Node $node): bool
    {
        return $this->getName() === $node->getName();
    }
}