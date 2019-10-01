<?php
/**
 * Copyright © Magently. All rights reserved.
 */

namespace Magently\UtilsProjectSetupHelper\Command;

use Magently\UtilsProjectSetupHelper\CommandContext;

/**
 * Interface CommandInterface
 * The interface responsible for providing methods for commands.
 * Command class must implement this interface.
 */
interface CommandInterface
{
    /**
     * Run command logic
     * @param null|mixed $value
     * @return void
     */
    public function run($value = null);

    /**
     * Display/return help text
     * @return string|null
     */
    public function help();

    /**
     * Get command name
     * @return string
     */
    public function getName();

    /**
     * Set CommandContext object
     * @param CommandContext $context
     * @return void
     */
    public function setContext(CommandContext $context);
}
