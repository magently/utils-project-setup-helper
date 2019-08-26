<?php

namespace Magently\UtilsProjectSetupHelper\Command;

use Magently\UtilsProjectSetupHelper\CommandContext;

class CreateAdminAccount implements CommandInterface
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

        $shell = $om->get(\Magento\Framework\App\Shell::class);
        $phpExecutableFinder = $om->get(\Symfony\Component\Process\PhpExecutableFinder::class);

        $phpPath = $phpExecutableFinder->find(false) ?: 'php';

        if ($value === null) {
            // use default values
            $username = 'admin';
            $password = 'admin123';
        } else {
            $accountData = explode('/', $value);
            $username = $accountData[0];
            $password = $accountData[1];
        }
        $email = $username . '+' . $password . '@example.com';

        $shell->execute(
            $phpPath . ' %s ' . 'admin:user:create %s %s %s %s %s',
            [
                BP . '/bin/magento',
                '--admin-user=' . $username,
                '--admin-password=' . $password,
                '--admin-email=' . $email,
                '--admin-firstname=admin',
                '--admin-lastname=admin'
            ]
        );

        $this->context->outputHelper()->writeln(
            'Admin user has been created. Username: ' . $username . ' Password: ' . $password
        );

    }

    public function help()
    {
        $this->context->outputHelper()->writeln(
            'Create admin account. Default values are admin/admin123. '
            . 'You can pass your values in username/password format.'
        );
    }

    public function getName()
    {
        return 'create_admin_account';
    }
}
