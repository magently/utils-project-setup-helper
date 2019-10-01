<?php
/**
 * Copyright © Magently. All rights reserved.
 */

namespace Magently\UtilsProjectSetupHelper;

/**
 * Class Configure
 * The class responsible for managing commands
 */
class Configure
{
    /**
     * @var CommandContext
     */
    private $commandContext;

    /**
     * @var array
     */
    private $config;

    /**
     * @var Command\CommandInterface[]
     */
    private $commands = [];

    /**
     * Configure constructor.
     * @param CommandContext $commandContext
     * @param array $config
     */
    public function __construct(
        CommandContext $commandContext,
        array $config
    ) {
        $this->commandContext = $commandContext;
        $this->config = $config;
    }

    /**
     * Create objects from Command classes
     * @throws \Exception If command doesn't implement CommandInterface.
     * @return void
     */
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

    /**
     * Print Welcome message
     * @return void
     */
    private function getWelcomeMessage()
    {
        $output = $this->commandContext->outputHelper();
        $output->writeln('<info>===============================</info>');
        $output->writeln('<info>Magently project setup helper</info>');
        $output->writeln('<info>===============================</info>');
        $output->writeln('');
    }

    /**
     * Print usage message
     * @return void
     */
    private function getUsageMessage()
    {
        $output = $this->commandContext->outputHelper();
        $output->writeln('Usage: ');
        $output->writeln(
            '<info>php vendor/bin/configure</info> - <comment>display this messages</comment>'
        );
        $output->writeln(
            '<info>php vendor/bin/configure run</info> - '
            . '<comment>run all commands with default values</comment>'
        );
        $output->writeln(
            '<info>php vendor/bin/configure {{command_name}}</info> - '
            .'<comment>run specific command with default value</comment>'
        );
        $output->writeln(
            '<info>php vendor/bin/configure {{command_name}} --help</info> - '
            .'<comment>display help message for specific command</comment>'
        );
        $output->writeln(
            '<info>php vendor/bin/configure {{command_name}} {{value}}</info> - '
            .'<comment>run specific command with your value</comment>'
        );
        $output->writeln('');
    }

    /**
     * Print help message for each command
     * @return void
     */
    public function getHelp()
    {
        $output = $this->commandContext->outputHelper();
        $this->getWelcomeMessage();
        $this->getUsageMessage();

        $output->writeln('<comment>Available commands: </comment>');
        foreach ($this->commands as $command) {
            $output->writeln('<comment>--></comment> ' . '<info>' . $command->getName() . '</info>');
            $output->writeln('Description: ');
            $output->writeln(
                $command->help()
            );

            $output->writeln('');
        }
    }

    /**
     * Run all commands
     * @return void
     */
    public function run()
    {
        $this->commandContext->outputHelper()->writeln('<comment>Running all commands</comment>');
        $this->commandContext->outputHelper()->writeln('');
        foreach ($this->commands as $commandName => $command) {
            $this->runCommand($commandName);
        }
    }

    /**
     * Run specific command
     * @param string $commandName
     * @param mixed $value
     * @throws \Exception If command doesn't exist.
     * @return void
     */
    public function runCommand($commandName, $value = null)
    {
        if (!isset($this->commands[$commandName])) {
            throw new \Exception(sprintf('Command %s does not exist', $commandName));
        }

        $this->commandContext->outputHelper()->writeln(
            '<comment>Running: </comment>' . '<info>' .$commandName . '</info>'
        );
        $this->commandContext->outputHelper()->writeln('');

        $this->commands[$commandName]->run($value);

        $this->commandContext->outputHelper()->writeln('');
    }

    /**
     * Print specific command help
     * @param string $commandName
     * @throws \Exception If command doesn't exist.
     * @return void
     */
    public function runCommandHelp($commandName)
    {
        if (!isset($this->commands[$commandName])) {
            throw new \Exception(sprintf('Command %s does not exist', $commandName));
        }

        $this->commandContext->outputHelper()->writeln(
            '<comment>Help for: </comment>' . '<info>' . $commandName . '</info>'
        );
        $this->commandContext->outputHelper()->writeln('');

        $this->commandContext->outputHelper()->writeln(
            '<comment>' . $this->commands[$commandName]->help() . '</comment>'
        );

        $this->commandContext->outputHelper()->writeln('');
    }
}
