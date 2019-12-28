<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/dbal project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Dbal\Connector;

interface ConnectorInterface
{
    /** @return mixed */
    public function getConnection();

    public function isConnected(): bool;

    public function disconnect(): void;

    public function getSettings(): array;
}
