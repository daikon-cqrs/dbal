<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/dbal project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Dbal\Migration;

use Assert\Assertion;

final class MigrationTarget implements MigrationTargetInterface
{
    private string $name;

    private bool $enabled;

    private MigrationAdapterInterface $migrationAdapter;

    private MigrationLoaderInterface $migrationLoader;

    public function __construct(
        string $name,
        bool $enabled,
        MigrationAdapterInterface $migrationAdapter,
        MigrationLoaderInterface $migrationLoader
    ) {
        $this->name = $name;
        $this->enabled = $enabled;
        $this->migrationAdapter = $migrationAdapter;
        $this->migrationLoader = $migrationLoader;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isEnabled(): bool
    {
        return $this->enabled === true;
    }

    public function getMigrationList(): MigrationList
    {
        $availableMigrations = $this->migrationLoader->load();
        $executedMigrations = $this->migrationAdapter->read($this->name);
        $pendingMigrations = $availableMigrations->exclude($executedMigrations);
        return $executedMigrations->append($pendingMigrations);
    }

    public function migrate(string $direction, int $version = null): MigrationList
    {
        Assertion::true($this->isEnabled());

        if ($direction === MigrationInterface::MIGRATE_DOWN) {
            $executedMigrations = $this->migrateDown($version);
        } else {
            $executedMigrations = $this->migrateUp($version);
        }

        return $executedMigrations;
    }

    private function migrateUp(int $version = null): MigrationList
    {
        $migrationList = $this->getMigrationList();
        $executedMigrations = $migrationList->getExecutedMigrations();
        $pendingMigrations = $migrationList->getPendingMigrations()->findBeforeVersion($version);

        $connector = $this->migrationAdapter->getConnector();
        foreach ($pendingMigrations as $migration) {
            $migration($connector, MigrationInterface::MIGRATE_UP);
            $executedMigrations = $executedMigrations->push($migration);
            $this->migrationAdapter->write($this->name, $executedMigrations);
        }

        return $pendingMigrations;
    }

    private function migrateDown(int $version = null): MigrationList
    {
        $migrationList = $this->getMigrationList();
        $executedMigrations = $migrationList->getExecutedMigrations();
        $reversedMigrations = new MigrationList;

        $connector = $this->migrationAdapter->getConnector();
        foreach ($executedMigrations->findAfterVersion($version)->reverse() as $migration) {
            $migration($connector, MigrationInterface::MIGRATE_DOWN);
            $reversedMigrations = $reversedMigrations->push($migration);
            $this->migrationAdapter->write($this->name, $executedMigrations->exclude($reversedMigrations));
        }

        return $reversedMigrations;
    }
}
