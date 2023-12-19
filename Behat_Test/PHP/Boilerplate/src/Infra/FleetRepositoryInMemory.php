<?php

namespace Behat_Test\Infra;

use Behat_Test\Domain\Interface\FleetRepositoryInterface;
use Behat_Test\Domain\ValueObject\Fleet;

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

    public function exist(Fleet $Fleet): int
    {
        return count($this->Fleet);
    }

    public function getFleetId(Fleet $Fleet): string
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
