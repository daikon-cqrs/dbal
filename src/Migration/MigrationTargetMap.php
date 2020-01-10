<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/dbal project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Dbal\Migration;

use Daikon\DataStructure\TypedMapInterface;
use Daikon\DataStructure\TypedMapTrait;

final class MigrationTargetMap implements TypedMapInterface
{
    use TypedMapTrait;

    public function __construct(iterable $migrationTargets = [])
    {
        $this->init($migrationTargets, [MigrationTargetInterface::class]);
    }

    public function getEnabledTargets(): self
    {
        return $this->filter(
            fn(string $name, MigrationTargetInterface $target): bool => $target->isEnabled()
        );
    }
}
