<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/dbal project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Dbal\Migration;

use Countable;
use Daikon\DataStructure\TypedMapTrait;
use IteratorAggregate;

final class MigrationTargetMap implements IteratorAggregate, Countable
{
    use TypedMapTrait;

    public function __construct(iterable $migrationTargets = [])
    {
        $this->init($migrationTargets, MigrationTargetInterface::class);
    }

    public function getEnabledTargets(): self
    {
        return new self(
            $this->compositeMap->filter(
                function (string $migrationName, MigrationTargetInterface $migrationTarget): bool {
                    return $migrationTarget->isEnabled();
                }
            )
        );
    }
}
