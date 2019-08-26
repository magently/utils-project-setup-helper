<?php

namespace Magently\UtilsProjectSetupHelper\Command;

use Magently\UtilsProjectSetupHelper\CommandContext;

class DisableMailCommunication implements CommandInterface
{
    /**
     * @var CommandContext
     */
    private $context;

    public function setContext(CommandContext $context)
    {
        $this->context = $context;
    }

    public function run($value = null)
    {
        $om = $this->context->objectManager();
        /**
         * @var $configWriter \Magento\Framework\App\Config\Storage\WriterInterface
         */
        $configWriter = $om->get(\Magento\Framework\App\Config\Storage\WriterInterface::class);

        if ($value === '0') {
            $msg = 'Mail communication has not been disabled';
        }
        elseif ($value === null || $value === '1') {
            // use default value
            $value = '1';
            $msg = 'Mail communication has been disabled';

        }

        $configWriter->save('system/smtp/disable', $value);

        $this->context->outputHelper()->writeln($msg);
    }

    public function help()
    {
        $this->context->outputHelper()->writeln(
            'Disable mail communications. Default value is 1'
        );
    }

    public function getName()
    {
        return 'disable_mail_communication';
    }
}
