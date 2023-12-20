<?php

namespace PhpUnit_Test\App\Validators;

use PhpUnit_Test\App\Validators\Config\Validator;

class CreateFleetValidator extends AbstractValidator
{
    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->validator->rule('required', 'fleetId');
        $this->validator->rule('lengthBetween', 'fleetId', 5, 5);
        $this->validator->rule('slug', 'fleetId');
    }
}
