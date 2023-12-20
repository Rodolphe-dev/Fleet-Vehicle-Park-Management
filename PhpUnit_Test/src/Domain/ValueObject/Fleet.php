<?php

namespace PhpUnit_Test\Domain\ValueObject;

class Fleet
{
    public function __construct(
        public string $fleetId
    ) {
        $this->fleetId = $fleetId;
    }

    /**
     * This is the fleet id of a fleet
     *
     * @return string
     */
    public function fleetId(): string
    {
        return $this->fleetId;
    }
}
