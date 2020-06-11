<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/dbal project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Tests\Dbal\Migration;

use Daikon\Dbal\Migration\MigrationAdapterInterface;
use Daikon\Dbal\Migration\MigrationAdapterMap;
use PHPUnit\Framework\TestCase;

final class MigrationAdapterMapTest extends TestCase
{
    public function testConstructWithSelf(): void
    {
        $adapterMock = $this->createMock(MigrationAdapterInterface::class);
        $adapterMap = new MigrationAdapterMap(['mock' => $adapterMock]);
        $newMap = new MigrationAdapterMap($adapterMap);
        $this->assertCount(1, $newMap);
        $this->assertNotSame($adapterMap, $newMap);
        $this->assertEquals($adapterMap, $newMap);
    }

    public function testPush(): void
    {
        $emptyMap = new MigrationAdapterMap;
        $adapterMock = $this->createMock(MigrationAdapterInterface::class);
        $adapterMap = $emptyMap->with('mock', $adapterMock);
        $this->assertCount(1, $adapterMap);
        $this->assertEquals($adapterMock, $adapterMap->get('mock'));
        $this->assertTrue($emptyMap->isEmpty());
    }
}
