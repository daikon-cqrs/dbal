<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/dbal project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Dbal\Connector;

trait ProvidesConnector
{
    private array $settings;

    /** @var mixed */
    private $connection;

    public function __construct(array $settings = [])
    {
        $this->settings = $settings;
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    public function getConnection()
    {
        if (!$this->isConnected()) {
            $this->connection = $this->connect();
        }

        return $this->connection;
    }

    public function isConnected(): bool
    {
        return $this->connection !== null;
    }

    public function disconnect(): void
    {
        if ($this->isConnected()) {
            $this->connection = null;
        }
    }

    public function getSettings(): array
    {
        return $this->settings;
    }

    /** @return mixed */
    abstract protected function connect();
}
