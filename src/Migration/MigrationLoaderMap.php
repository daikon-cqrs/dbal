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

final class MigrationLoaderMap implements IteratorAggregate, Countable
{
    use TypedMapTrait;

    public function __construct(iterable $migrationLoaders = [])
    {
        $this->init($migrationLoaders, MigrationLoaderInterface::class);
    }
}
