<?php

namespace PhpUnit_Test\Domain\Interface;

use PhpUnit_Test\Domain\ValueObject\Fleet;

interface FleetRepositoryInterface
{
    public function getAll(): array;

    public function getFleetId(Fleet $Fleet);

    public function exist(Fleet $Fleet);

    public function save(Fleet $Fleet) : void;
}
