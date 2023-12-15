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

    public function exist(Fleet $Fleet)
    {
        if (!array_key_exists($Fleet->fleetId(), $this->Fleet)) {
            return 0;
        }else{
            return null;
        }
    }

    public function getFleetId(Fleet $Fleet)
    {
        if (!array_key_exists($Fleet->fleetId(), $this->Fleet)) {
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
