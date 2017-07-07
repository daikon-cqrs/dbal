<?php

namespace Daikon\Dbal\Connector;

use Daikon\DataStructure\TypedMapTrait;

final class ConnectorMap implements \IteratorAggregate, \Countable
{
    use TypedMapTrait;

    public function __construct(array $connectors = [])
    {
        $this->init($connectors, ConnectorInterface::class);
    }
}
