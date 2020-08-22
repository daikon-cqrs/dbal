<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/dbal project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Dbal\Migration;

interface MigrationTargetInterface
{
    public function getKey(): string;

    public function isEnabled(): bool;

    public function getMigrationList(): MigrationList;

    public function migrate(string $direction, int $version = null): MigrationList;
}
