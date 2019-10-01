<?php
/**
 * Copyright © Magently. All rights reserved.
 */

namespace Magently\UtilsProjectSetupHelper;

use Magento\Framework\ObjectManagerInterface;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Class CommandContext
 * The class responsible for providing helper methods for commands
 */
class CommandContext
{
    /**
     * @var ObjectManagerInterface
     */
    private $om;

    /**
     * @var ConsoleOutput
     */
    private $outputHelper;

    /**
     * CommandContext constructor.
     * @param ObjectManagerInterface $om
     * @param ConsoleOutput $outputHelper
     */
    public function __construct(
        ObjectManagerInterface $om,
        ConsoleOutput $outputHelper
    ) {
        $this->om = $om;
        $this->outputHelper = $outputHelper;
    }

    /**
     * @return ObjectManagerInterface
     */
    public function objectManager()
    {
        return $this->om;
    }

    /**
     * @return ConsoleOutput
     */
    public function outputHelper()
    {
        return $this->outputHelper;
    }
}
