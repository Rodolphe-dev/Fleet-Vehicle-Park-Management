<?php

namespace Behat_Test\Domain\ValueObject;

class Fleet
{
    public function __construct(
        public string $fleetId
        )
    {
        $this->fleetId = $fleetId;
    }

    public function fleetId(): string
    {
        return $this->fleetId;
    }
}
