<?php

namespace Behat_Test\App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Valitron\Validator;
use Behat_Test\App\Validators\RegisterVehicleValidator;
use Behat_Test\Infra\FleetRepositoryInDB;
use Behat_Test\Domain\ValueObject\Fleet;
use Behat_Test\App\Handler\RegisterVehicleHandler;
use Behat_Test\Infra\VehicleRepositoryInDB;
use Behat_Test\Domain\ValueObject\Vehicle;
use Behat_Test\Infra\CQRS\ReadFleetRepository;
use Behat_Test\Infra\CQRS\WriteFleetRepository;
use Behat_Test\Infra\CQRS\ReadVehicleRepository;
use Behat_Test\Infra\CQRS\WriteVehicleRepository;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: './fleet_register_vehicle')]
class RegisterVehicleCommand extends Command
{
    private $fleetId;
    private $plateNumber;

    private Vehicle $Vehicle;

    private FleetRepositoryInDB $FleetRepository;
    private VehicleRepositoryInDB $VehicleRepository;

    private ReadFleetRepository $ReadFleetRepository;
    private WriteFleetRepository $WriteFleetRepository;

    private ReadVehicleRepository $ReadVehicleRepository;
    private WriteVehicleRepository $WriteVehicleRepository;

    public function __construct(bool $fleetId = false, bool $plateNumber = false)
    {
        $this->FleetRepository = new FleetRepositoryInDB();
        $this->VehicleRepository = new VehicleRepositoryInDB();

        $this->ReadFleetRepository = new ReadFleetRepository($this->FleetRepository);
        $this->WriteFleetRepository = new WriteFleetRepository($this->FleetRepository);

        $this->ReadVehicleRepository = new ReadVehicleRepository($this->VehicleRepository);
        $this->WriteVehicleRepository = new WriteVehicleRepository($this->VehicleRepository);

        $this->fleetId = $fleetId;
        $this->plateNumber = $plateNumber;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command allows you to register a vehicle in a fleet');

        $this->addArgument('fleetId', InputArgument::REQUIRED, 'The Vehicle Fleet Id');
        $this->addArgument('plateNumber', InputArgument::REQUIRED, 'The Vehicle plateNumber');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        Validator::lang('en');
        $v = new RegisterVehicleValidator(
            array(
                'fleetId' => $input->getArgument('fleetId'),
                'plateNumber' => $input->getArgument('plateNumber')
            )
        );

        if ($v->validate()) {
            //Check if Fleet exist
            $Fleet = new Fleet($input->getArgument('fleetId'));
            $checkFleet = $this->ReadFleetRepository->exist($Fleet);
            if ($checkFleet !== 0) {
                //Check if Vehicle exist
                $Vehicle = new Vehicle($input->getArgument('fleetId'), $input->getArgument('plateNumber'), '0', '0');

                $checkVehicle = $this->ReadVehicleRepository->exist($Vehicle);

                if ($checkVehicle === 0) {
                    $RegisterVehicleHandler = new RegisterVehicleHandler(
                        $this->ReadFleetRepository,
                        $this->WriteFleetRepository,
                        $this->ReadVehicleRepository,
                        $this->WriteVehicleRepository
                    );
                    $Vehicle = new Vehicle(
                        $input->getArgument('fleetId'),
                        $input->getArgument('plateNumber'),
                        '0',
                        '0'
                    );
                    $this->Vehicle = $RegisterVehicleHandler($Vehicle);

                    $output->writeln(
                        [
                            'Vehicle Creator',
                            '============',
                            '',
                        ]
                    );

                    $output->write(
                        "Vehicle '" .
                            $input->getArgument('plateNumber') .
                            "' is register in Fleet '" .
                            $input->getArgument('fleetId') . "'"
                    );
                } else {
                    $output->writeln(
                        [
                            'Vehicle Creator',
                            '============',
                            '',
                        ]
                    );

                    $output->write(
                        "Vehicle '" .
                            $input->getArgument('plateNumber') .
                            "' is already register in this Fleet '" .
                            $input->getArgument('fleetId') . "'"
                    );
                }
            } else {
                $output->writeln(
                    [
                        'Vehicle Creator',
                        '============',
                        '',
                    ]
                );

                $output->write(
                    "Vehicle '" .
                        $input->getArgument('plateNumber') .
                        "' can't register in this Fleet '" .
                        $input->getArgument('fleetId') .
                        "' because this fleet doesn't exist"
                );
            }

            return Command::SUCCESS;
        } else {
            $errors = $v->errors();

            $output->writeln(
                [
                    'Vehicle Creator',
                    '============',
                    '',
                ]
            );

            $errors = $v->errors();
            if (!empty($errors['fleetId'])) {
                $output->writeln("Fleet Id" . $errors['fleetId']['0'] . "");
            }

            if (!empty($errors['plateNumber'])) {
                $output->write("Plate Number" . $errors['plateNumber']['0'] . "");
            }

            return Command::INVALID;
        }
    }
}
