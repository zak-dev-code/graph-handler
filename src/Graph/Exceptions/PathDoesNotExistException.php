<?php

declare(strict_types=1);

namespace ZakDevCode\GraphHandler\Graph\Exceptions;

class PathDoesNotExistException extends GraphException
{
    public function __construct()
    {
        parent::__construct('Path does not exist');
    }
}