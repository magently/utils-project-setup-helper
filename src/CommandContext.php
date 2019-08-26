<?php

namespace Magently\UtilsProjectSetupHelper;

use Magento\Framework\ObjectManagerInterface;

class CommandContext
{
    private $om;
    private $outputHelper;

    public function __construct(
        $om,
        $outputHelper
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
     * @return \Symfony\Component\Console\Output\ConsoleOutput
     */
    public function outputHelper()
    {
        return $this->outputHelper;
    }
}
