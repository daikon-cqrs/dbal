<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/dbal project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Dbal\Migration;

use Daikon\Dbal\Connector\ConnectorInterface;
use Daikon\Interop\ToNativeInterface;

interface MigrationInterface extends ToNativeInterface
{
    public const MIGRATE_UP = 'up';

    public const MIGRATE_DOWN = 'down';

    public function getName(): string;

    public function getVersion(): int;

    public function getDescription(string $direction = self::MIGRATE_UP): string;

    public function isReversible(): bool;

    public function hasExecuted(): bool;

    public function execute(ConnectorInterface $connector, string $direction = self::MIGRATE_UP): void;
}
