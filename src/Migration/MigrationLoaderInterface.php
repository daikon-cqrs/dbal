<?php

namespace Daikon\Dbal\Migration;

interface MigrationLoaderInterface
{
    public function load(): MigrationList;
}
