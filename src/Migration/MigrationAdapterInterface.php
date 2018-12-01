<?php
/**
 * This file is part of the daikon-cqrs/dbal project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Daikon\Dbal\Migration;

use Daikon\Dbal\Connector\ConnectorInterface;

interface MigrationAdapterInterface
{
    public function read(string $identifier): MigrationList;

    public function write(string $identifier, MigrationList $migrationList): void;

    public function getConnector(): ConnectorInterface;
}
