<?php

namespace Behat_Test\App\Validators;

use Behat_Test\App\Validators\Config\Validator;

class RegisterVehicleValidator extends AbstractValidator
{
    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->validator->rule('required', 'fleetId');
        $this->validator->rule('lengthBetween', 'fleetId', 5, 5);
        $this->validator->rule('slug', 'fleetId');
        $this->validator->rule('required', 'plateNumber');
        $this->validator->rule('lengthBetween', 'plateNumber', 9, 9);
        $this->validator->rule('slug', 'plateNumber');
    }
}
