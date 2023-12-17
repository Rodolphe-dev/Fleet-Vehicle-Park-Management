<?php

namespace PhpUnit_Test\Infra;

use PhpUnit_Test\Domain\Interface\FleetRepositoryInterface;
use PhpUnit_Test\Domain\ValueObject\Fleet;

class FleetRepositoryInMemory implements FleetRepositoryInterface
{
    protected $Fleet;

    public function __construct()
    {
        $this->Fleet = [];
    }

    public function getAll(): array
    {
        return $this->Fleet;
    }

    public function exist(Fleet $Fleet)
    {
        return count($this->Fleet);
    }

    public function getFleetId(Fleet $Fleet)
    {
        foreach ($this->Fleet as $item) {
            if ($item->fleetId == $Fleet->fleetId()) {
                return $item->fleetId;
            }
        }
    }

    public function save(Fleet $Fleet): void
    {
        $this->Fleet[] = $Fleet;
    }
}
