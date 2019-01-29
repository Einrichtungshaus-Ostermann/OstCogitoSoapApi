<?php declare(strict_types=1);

/**
 * Einrichtungshaus Ostermann GmbH & Co. KG - Cogito Soap Api
 *
 * A connector for the Cogito SOAP API.
 *
 * 1.0.0
 * - initial release
 *
 * 1.0.1
 * - fixed plugin name
 *
 * 1.0.2
 * - added plugin configuration for shipping and payment mapping via attribute
 *
 * 1.1.0
 * - added shipping costs
 *
 * 1.1.1
 * - added more configuration options
 *
 * 1.1.2
 * - added debugging configuration
 *
 * 1.1.3
 * - fixed configuration
 *
 * 1.1.4
 * - fixed configuration
 *
 * 1.1.5
 * - added environment for printer
 * - added debugging configuration for printer
 *
 * 1.1.6
 * - fixed environment for printer
 *
 * 1.1.7
 * - fixed environment for printer
 *
 * 1.2.0
 * - added configuration to ignore shipping costs and to not send them via api
 *
 * 1.2.1
 * - added OST_QSK to environment configuration
 * - added response to xml logs
 *
 * 1.2.2
 * - added auto completion for print backend controller tests
 *
 * 1.2.3
 * - fixed salutation in address xml
 *
 * @package   OstCogitoSoapApi
 *
 * @author    Tim Windelschmidt <tim.windelschmidt@ostermann.de>
 * @copyright 2018 Einrichtungshaus Ostermann GmbH & Co. KG
 * @license   proprietary
 */

namespace OstCogitoSoapApi;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OstCogitoSoapApi extends Plugin
{
    /**
     * ...
     *
     * @var string
     */
    const NS_COGITO_DATA_ORDER = 'CogitoRetailWeb.Data.Order';

    /**
     * ...
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        // set plugin parameters
        $container->setParameter('ost_cogito_soap_api.plugin_dir', $this->getPath() . '/');
        $container->setParameter('ost_cogito_soap_api.view_dir', $this->getPath() . '/Resources/views/');

        // call parent builder
        parent::build($container);
    }

    /**
     * Activate the plugin.
     *
     * @param Context\ActivateContext $context
     */
    public function activate(Context\ActivateContext $context)
    {
        // clear complete cache after we activated the plugin
        $context->scheduleClearCache($context::CACHE_LIST_ALL);
    }

    /**
     * Install the plugin.
     *
     * @param Context\InstallContext $context
     *
     * @throws \Exception
     */
    public function install(Context\InstallContext $context)
    {
        // install the plugin
        $installer = new Setup\Install(
            $this,
            $context,
            $this->container->get('models'),
            $this->container->get('shopware_attribute.crud_service')
        );
        $installer->install();

        // update it to current version
        $updater = new Setup\Update(
            $this,
            $context
        );
        $updater->install();

        // call default installer
        parent::install($context);
    }

    /**
     * Update the plugin.
     *
     * @param Context\UpdateContext $context
     */
    public function update(Context\UpdateContext $context)
    {
        // update the plugin
        $updater = new Setup\Update(
            $this,
            $context
        );
        $updater->update($context->getCurrentVersion());

        // call default updater
        parent::update($context);
    }

    /**
     * Uninstall the plugin.
     *
     * @param Context\UninstallContext $context
     *
     * @throws \Exception
     */
    public function uninstall(Context\UninstallContext $context)
    {
        // uninstall the plugin
        $uninstaller = new Setup\Uninstall(
            $this,
            $context,
            $this->container->get('models'),
            $this->container->get('shopware_attribute.crud_service')
        );
        $uninstaller->uninstall();

        // clear complete cache
        $context->scheduleClearCache($context::CACHE_LIST_ALL);

        // call default uninstaller
        parent::uninstall($context);
    }
}
