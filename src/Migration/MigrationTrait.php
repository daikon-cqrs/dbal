<?php
/**
 * This file is part of the daikon-cqrs/dbal project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Daikon\Dbal\Migration;

use Assert\Assertion;
use Daikon\Dbal\Connector\ConnectorInterface;
use Daikon\Dbal\Exception\MigrationException;

trait MigrationTrait
{
    private $executedAt;

    private $connector;

    public function __construct(\DateTimeImmutable $executedAt = null)
    {
        $this->executedAt = $executedAt;
    }

    public function execute(ConnectorInterface $connector, string $direction = self::MIGRATE_UP): void
    {
        $this->connector = $connector;

        if ($direction === self::MIGRATE_DOWN) {
            Assertion::true($this->isReversible(), 'Migration cannot be reversed');
            Assertion::true($this->hasExecuted(), 'Migration has not previously been executed');
            $this->down();
            $this->executedAt = null;
        } else {
            Assertion::false($this->hasExecuted(), 'Migration has already been executed');
            $this->up();
            $this->executedAt = new \DateTimeImmutable('now');
        }
    }

    public function getName(): string
    {
        $shortName = (new \ReflectionClass(static::class))->getShortName();
        if (!preg_match('#^(?<name>.+?)\d+$#', $shortName, $matches)) {
            throw new MigrationException('Unexpected migration name in '.$shortName);
        }
        return $matches['name'];
    }

    public function getVersion(): int
    {
        $shortName= (new \ReflectionClass(static::class))->getShortName();
        if (!preg_match('#(?<version>\d{14})$#', $shortName, $matches)) {
            throw new MigrationException('Unexpected migration version in '.$shortName);
        }
        return intval($matches['version']);
    }

    public function hasExecuted(): bool
    {
        return $this->executedAt instanceof \DateTimeImmutable;
    }

    public function toNative(): array
    {
        $arr = [
            '@type' => static::class,
            'name' => $this->getName(),
            'version' => $this->getVersion(),
            'description' => $this->getDescription()
        ];

        if ($this->hasExecuted()) {
            $arr['executedAt']  = $this->executedAt->format('c');
        }

        return $arr;
    }
}
