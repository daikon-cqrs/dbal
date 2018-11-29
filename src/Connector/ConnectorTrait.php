<?php

namespace Daikon\Dbal\Connector;

trait ConnectorTrait
{
    /** @var array */
    private $settings;

    /** @var mixed */
    private $connection;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    /** @return mixed */
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
