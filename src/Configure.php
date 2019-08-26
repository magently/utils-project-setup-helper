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

    private function getWelcomeMessage()
    {
        $output = $this->commandContext->outputHelper();
        $output->writeln('<info>===============================</info>');
        $output->writeln('<info>Magently project setup helper</info>');
        $output->writeln('<info>===============================</info>');
        $output->writeln('');
    }

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

    public function getHelp()
    {
        $output = $this->commandContext->outputHelper();
        $this->getWelcomeMessage();
        $this->getUsageMessage();

        $output->writeln('<comment>Available commands: </comment>');
        foreach ($this->commands as $command) {
            $output->writeln('<comment>--></comment> ' . '<info>' . $command->getName() . '</info>');
            $output->writeln('Description: ');
            $command->help();

            $output->writeln('');
        }
    }

    public function run()
    {
        $this->commandContext->outputHelper()->writeln('<comment>Running all commands</comment>');
        $this->commandContext->outputHelper()->writeln('');
        foreach ($this->commands as $commandName => $command) {
            $this->runCommand($commandName);
        }
    }

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
