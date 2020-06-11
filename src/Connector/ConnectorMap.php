<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/dbal project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Dbal\Connector;

use Daikon\DataStructure\TypedMap;

final class ConnectorMap extends TypedMap
{
    public function __construct(iterable $connectors = [])
    {
        $this->init($connectors, [ConnectorInterface::class]);
    }
}
