<?php
/**
 * Copyright © Magently. All rights reserved.
 */

namespace Magently\UtilsProjectSetupHelper\Command;

use Magently\UtilsProjectSetupHelper\CommandContext;

/**
 * Class ChangeBaseUrl
 * The class responsible for setting base url
 */
class ChangeBaseUrl implements CommandInterface
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
        /** @var $resource \Magento\Framework\App\ResourceConnection */
        $resource = $om->get(\Magento\Framework\App\ResourceConnection::class);
        $connection = $resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);

        $paths = [
            'web/unsecure/base_url',
            'web/unsecure/base_link_url',
            'web/unsecure/base_static_url',
            'web/unsecure/base_media_url',
            'web/secure/base_url',
            'web/secure/base_link_url',
            'web/secure/base_static_url',
            'web/secure/base_media_url',
            'web/cookie/cookie_path',
            'web/cookie/cookie_domain'
        ];

        $connection->delete(
            $connection->getTableName('core_config_data'),
            ['path IN (?)' => $paths]
        );

        if (!$value) {
            $value = '{{base_url}}';
        }

        $configWriter->save('web/unsecure/base_url', $value);
        $configWriter->save('web/secure/base_url', $value);

        $this->context->outputHelper()->writeln(
            sprintf('Done. Base URL has been changed to %s', $value)
        );
    }

    /**
     * {@inheritDoc}
     * @return string
     */
    public function help()
    {
        return 'Change base URL. Pass base_url value or leave empty to use {{base_url}}';
    }

    /**
     * {@inheritDoc}
     * @return string
     */
    public function getName()
    {
        return 'change_base_url';
    }
}
