<?php

namespace PhpUnit_Test\App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Valitron\Validator;
use PhpUnit_Test\App\Validators\CreateFleetValidator;
use PhpUnit_Test\App\Handler\CreateFleetHandler;
use PhpUnit_Test\Infra\FleetRepositoryInDB;
use PhpUnit_Test\Domain\ValueObject\Fleet;
use PhpUnit_Test\Infra\CQRS\ReadFleetRepository;
use PhpUnit_Test\Infra\CQRS\WriteFleetRepository;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: './fleet_create')]
class CreateFleetCommand extends Command
{
    private $fleetId;
    private Fleet $Fleet;

    private FleetRepositoryInDB $FleetRepository;

    private ReadFleetRepository $ReadFleetRepository;
    private WriteFleetRepository $WriteFleetRepository;

    public function __construct(bool $fleetId = false)
    {
        $this->FleetRepository = new FleetRepositoryInDB();

        $this->ReadFleetRepository = new ReadFleetRepository($this->FleetRepository);
        $this->WriteFleetRepository = new WriteFleetRepository($this->FleetRepository);

        $this->fleetId = $fleetId;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command allows you to create a fleet');

        $this->addArgument('fleetId', InputArgument::REQUIRED, 'The Fleet Id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        Validator::lang('en');
        $v = new CreateFleetValidator(array('fleetId' => $input->getArgument('fleetId')));

        if ($v->validate()) {
            //Check if Fleet exist
            $Fleet = new Fleet($input->getArgument('fleetId'));

            $checkFleet = $this->ReadFleetRepository->exist($Fleet);

            if ($checkFleet === 0) {
                $FleetHandler = new CreateFleetHandler($this->ReadFleetRepository, $this->WriteFleetRepository);
                $fleetId = new Fleet($input->getArgument('fleetId'));
                $this->Fleet = $FleetHandler($fleetId);

                $output->writeln(
                    [
                    'Fleet Creator',
                    '============',
                    '',
                    ]
                );

                $output->write("Fleet '" . $input->getArgument('fleetId') . "' is register");
            } else {
                $output->writeln(
                    [
                    'Fleet Creator',
                    '============',
                    '',
                    ]
                );

                $output->write("Fleet '" . $input->getArgument('fleetId') . "' already exist");
            }

            return Command::SUCCESS;
        } else {
            $errors = $v->errors();

            $output->writeln(
                [
                'Fleet Creator',
                '============',
                '',
                ]
            );

            $errors = $v->errors();
            $output->write("Fleet Id" . $errors['fleetId']['0'] . "");

            return Command::INVALID;
        }
    }
}
