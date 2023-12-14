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

    public function getFleetId(Fleet $Fleet)
    {
        if (isset($this->Fleet[$Fleet->fleetId()])) {
            return $this->Fleet[$Fleet->fleetId()];
        }else{
            return null;
        }
    }

    public function save(Fleet $Fleet): void
    {
        $this->Fleet[] = $Fleet;
    }
}
