<?php

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;
use ZakDevCode\GraphHandler\Graph\Node;

class NodeTest extends TestCase
{
    public function testNodeCreate(): void
    {
        $node = new Node('test');

        $this->assertEquals('test', $node->getName());
        $this->assertEquals([], $node->getExtraData());

        $node = new Node('test_with_data', ['data' => true]);

        $this->assertEquals('test_with_data', $node->getName());
        $this->assertEquals(['data' => true], $node->getExtraData());
    }

    public function testEqual(): void
    {
        $nodeOne = new Node('testEqual');
        $nodeTwo = new Node('testEqual');

        $this->assertTrue($nodeOne->isEqual($nodeTwo));
        $this->assertTrue($nodeTwo->isEqual($nodeOne));
    }
}