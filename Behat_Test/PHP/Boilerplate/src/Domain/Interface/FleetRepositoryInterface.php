<?php

namespace Behat_Test\Domain\Interface;

use Behat_Test\Domain\ValueObject\Fleet;

interface FleetRepositoryInterface
{
    public function getAll(): array;

    public function getFleetId(Fleet $Fleet);

    public function exist(Fleet $Fleet);

    public function save(Fleet $Fleet) : void;
}