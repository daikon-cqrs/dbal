<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/dbal project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Tests\Dbal\Connector;

use Daikon\Dbal\Connector\ConnectorInterface;
use Daikon\Dbal\Connector\ConnectorMap;
use PHPUnit\Framework\TestCase;

final class ConnectorMapTest extends TestCase
{
    public function testConstructWithSelf(): void
    {
        $connectorMock = $this->createMock(ConnectorInterface::class);
        $connectorMap = new ConnectorMap(['mock' => $connectorMock]);
        $newMap = new ConnectorMap($connectorMap);
        $this->assertCount(1, $newMap);
        $this->assertNotSame($connectorMap, $newMap);
        $this->assertEquals($connectorMap, $newMap);
    }

    public function testPush(): void
    {
        $emptyMap = new ConnectorMap;
        $connectorMock = $this->createMock(ConnectorInterface::class);
        $connectorMap = $emptyMap->with('mock', $connectorMock);
        $this->assertCount(1, $connectorMap);
        $this->assertEquals($connectorMock, $connectorMap->get('mock'));
        $this->assertTrue($emptyMap->isEmpty());
    }
}
