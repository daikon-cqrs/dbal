<?php

namespace Daikon\Dbal\Projection;

use Daikon\Cqrs\Aggregate\DomainEventInterface;

interface ProjectionInterface
{
    public function getAggregateId(): string;

    public function getAggregateRevision(): int;

    public function applyEvent(DomainEventInterface $domainEvent): ProjectionInterface;

    public function toArray(): array;
}
