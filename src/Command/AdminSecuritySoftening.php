<?php
/**
 * Copyright © Magently. All rights reserved.
 */

namespace Magently\UtilsProjectSetupHelper\Command;

use Magently\UtilsProjectSetupHelper\CommandContext;

/**
 * Class AdminSecuritySoftening
 * The class responsible for setting less stringent admin security settings.
 */
class AdminSecuritySoftening implements CommandInterface
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
        /** @var $configWriter \Magento\Framework\App\Config\Storage\WriterInterface */
        $configWriter = $om->get(\Magento\Framework\App\Config\Storage\WriterInterface::class);

        if ($value === '0') {
            $msg = 'Nothing has been changed';
        } elseif ($value === null || $value === '1') {
            $configWriter->save('admin/security/use_case_sensitive_login', '0');
            $configWriter->save('admin/security/session_lifetime', '31536000');
            $configWriter->save('admin/security/password_lifetime', '0');
            $configWriter->save('admin/security/admin_account_sharing', '1');
            $configWriter->save('admin/captcha/enable', '0');

            $msg = 'Admin security has been made less stringent.';
        }

        $this->context->outputHelper()->writeln($msg);
    }

    /**
     * {@inheritDoc}
     * @return void
     */
    public function help()
    {
        $this->context->outputHelper()->writeln(
            'Set less stringent admin settings. Pass "0" to not run the command. This command includes: '
        );
        $this->context->outputHelper()->writeln(
            'Set "Use case sensitive login" to No'
        );
        $this->context->outputHelper()->writeln(
            'Set "admin session lifetime" to 31536000 (1 year)'
        );
        $this->context->outputHelper()->writeln(
            'Set "admin password lifetime" to 0 (feature will be disabled)'
        );
        $this->context->outputHelper()->writeln(
            'Set "admin account sharing" to Yes'
        );
        $this->context->outputHelper()->writeln(
            'Disable captcha'
        );
    }

    /**
     * {@inheritDoc}
     * @return string
     */
    public function getName()
    {
        return 'admin_security_softening';
    }
}
