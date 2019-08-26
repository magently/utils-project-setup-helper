<?php

namespace Magently\UtilsProjectSetupHelper;

class Configure
{
    private $commandContext;
    private $config;

    /**
     * @var Command\CommandInterface[]
     */
    private $commands = [];

    public function __construct(
        CommandContext $commandContext,
        array $config
    ) {
        $this->commandContext = $commandContext;
        $this->config = $config;
    }

    public function configure()
    {
        foreach ($this->config as $commandName => $commandClass) {
            $object = new $commandClass();

            if (!$object instanceof Command\CommandInterface) {
                throw new \Exception(sprintf(
                    'Command "%s" must implement %s',
                    $commandName,
                    \Magently\UtilsProjectSetupHelper\Command\CommandInterface::class
                ));
            }

            $object->setContext($this->commandContext);
            $this->commands[$commandName] = $object;
        }
    }

    public function getHelp()
    {
        $output = $this->commandContext->outputHelper();
        $output->writeln('Project setup helper. Available commands:');
        $output->breakLine();
        foreach ($this->commands as $command) {

            $output->writeln($command->getName());
            $output->writeln('Description: ');
            $command->help();

            $output->breakLine();
        }
    }

    public function run()
    {
        foreach ($this->commands as $commandName => $command) {
            $this->commandContext->outputHelper()->breakLine();
            $this->commandContext->outputHelper()->writeln('Running: ' . $commandName);
            $this->commandContext->outputHelper()->breakLine();

            $command->run();

            $this->commandContext->outputHelper()->breakLine();
        }
    }

    public function runCommand($commandName, $value = null)
    {
        $this->commandContext->outputHelper()->writeln('Running: ' . $commandName);
        $this->commandContext->outputHelper()->breakLine();

        $this->commands[$commandName]->run($value);

        $this->commandContext->outputHelper()->breakLine();
    }

    public function runCommandHelp($commandName)
    {
        $this->commandContext->outputHelper()->writeln('Help for: ' . $commandName);
        $this->commandContext->outputHelper()->breakLine();

        $this->commands[$commandName]->help();

        $this->commandContext->outputHelper()->breakLine();
    }
}
