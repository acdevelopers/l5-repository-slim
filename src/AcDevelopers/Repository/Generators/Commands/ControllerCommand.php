<?php

namespace AcDevelopers\Repository\Generators\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use AcDevelopers\Repository\Generators\ControllerGenerator;
use AcDevelopers\Repository\Generators\FileAlreadyExistsException;

/**
 * Class ControllerCommand
 * 
 * @package AcDevelopers\Repository\Generators\Commands
 * @author Anitche CHisom
 */
class ControllerCommand extends Command
{
    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'make:resource';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new RESTful controller.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * ControllerCommand constructor.
     */
    public function __construct()
    {
        $this->name = ((float) app()->version() >= 5.5  ? 'make:rest-controller' : 'make:resource');
        parent::__construct();
    }

    /**
     * Execute the command.
     *
     * @see fire()
     * @return void
     */
    public function handle(){
        $this->laravel->call([$this, 'fire'], func_get_args());
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function fire()
    {
        try {
            // Generate create request for controller
            $this->call('make:request', [
                'name' => $this->argument('name') . 'CreateRequest'
            ]);

            // Generate update request for controller
            $this->call('make:request', [
                'name' => $this->argument('name') . 'UpdateRequest'
            ]);

            // Generate resource for controller
            $this->call('make:resource', [
                'name' => $this->argument('name')
            ]);

            // Generate resource collection for controller
            $this->call('make:resource', [
                'name' => $this->argument('name') . 'Collection'
            ]);

            (new ControllerGenerator([
                'name' => $this->argument('name'),
                'force' => $this->option('force'),
            ]))->run();

            $this->info($this->type . ' created successfully.');

        } catch (FileAlreadyExistsException $e) {
            $this->error($this->type . ' already exists!');

            return false;
        }
    }


    /**
     * The array of command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of model for which the controller is being generated.',
                null
            ],
        ];
    }

    /**
     * The array of command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            [
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Force the creation if file already exists.',
                null
            ],
        ];
    }
}
