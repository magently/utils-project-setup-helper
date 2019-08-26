<?php

namespace Magently\UtilsProjectSetupHelper\Command;

use Magently\UtilsProjectSetupHelper\CommandContext;

interface CommandInterface
{
    public function run($value = null);
    public function help();
    public function setContext(CommandContext $context);
    public function getName();
}
