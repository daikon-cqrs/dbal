<?php

namespace Daikon\Dbal\Storage;

interface StorageAdapterInterface
{
    public function read(string $identifier);

    public function write(string $identifier, array $data);

    public function delete(string $identifier);
}
