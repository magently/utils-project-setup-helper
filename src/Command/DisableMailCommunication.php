<?php
/**
 * Copyright © Magently. All rights reserved.
 */

namespace Magently\UtilsProjectSetupHelper\Command;

use Magently\UtilsProjectSetupHelper\CommandContext;

/**
 * Class DisableMailCommunication
 * The class responsible for disabling mail communication in Magento backend
 */
class DisableMailCommunication implements CommandInterface
{
    /**
     * @var CommandContext
     */
    private $context;

    /**
     * {@inheritDoc}
     * @param CommandContext $context
     * @return void
     */
    public function setContext(CommandContext $context)
    {
        $this->context = $context;
    }

    /**
     * {@inheritDoc}
     * @param null|string $value
     * @return void
     */
    public function run($value = null)
    {
        $om = $this->context->objectManager();
        /**
         * @var $configWriter \Magento\Framework\App\Config\Storage\WriterInterface
         */
        $configWriter = $om->get(\Magento\Framework\App\Config\Storage\WriterInterface::class);

        if ($value === '0') {
            $msg = 'Mail communication has not been disabled';
        } elseif ($value === null || $value === '1') {
            // use default value
            $value = '1';
            $msg = 'Mail communication has been disabled';
        }

        $configWriter->save('system/smtp/disable', $value);

        $this->context->outputHelper()->writeln($msg);
    }

    /**
     * {@inheritDoc}
     * @return string
     */
    public function help()
    {
        return 'Disable mail communications. Default value is 1';
    }

    /**
     * {@inheritDoc}
     * @return string
     */
    public function getName()
    {
        return 'disable_mail_communication';
    }
}
