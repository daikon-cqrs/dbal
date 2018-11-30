<?php
/**
 * This file is part of the daikon-cqrs/dbal project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

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
