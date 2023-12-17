<?php
namespace PhpUnit_Test\App\Validators;

use PhpUnit_Test\App\Validators\Config\Validator;

class ParkVehicleValidator extends AbstractValidator {

    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->validator->rules([
            'required' => [
                ['fleetId'],
                ['plateNumber'],
                ['latitude'],
                ['longitude']
            ]
        ]);

        $this->validator->rules([
            'lengthBetween' => [
                ['fleetId', 5, 5],
                ['plateNumber', 9, 9],
                ['latitude', 1, 10],
                ['longitude', 1, 10]
            ]
        ]);

        $this->validator->rules([
            'slug' => [
                ['fleetId'],
                ['plateNumber']
            ]
        ]);

        $this->validator->rules([
            'numeric' => [
                ['latitude'],
                ['longitude']
            ]
        ]);
    }
}