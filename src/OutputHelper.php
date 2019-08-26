<?php

namespace Magently\UtilsProjectSetupHelper;

class OutputHelper
{
    public function breakLine()
    {
        print PHP_EOL;
    }

    public function writeln($message)
    {
        print $message . $this->breakLine();
    }
}
