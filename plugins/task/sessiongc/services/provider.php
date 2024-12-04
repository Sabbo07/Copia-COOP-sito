<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Task.sessionGC
 *
 * @copyright   (C) 2023 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Session\MetadataManager;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;
use Joomla\Plugin\Task\SessionGC\Extension\SessionGC;

return new class () implements ServiceProviderInterface {
    /**
     * Registers the service provider with a DI container.
     *
     * @param   Container  $container  The DI container.
     *
     * @return  void
     *
     * @since   5.0.0
     */
    public function register(Container $container): void
    {
        $container->set(
            PluginInterface::class,
            function (Container $container) {
                $plugin = new SessionGC(
                    $container->get(DispatcherInterface::class),
                    (array) PluginHelper::getPlugin('task', 'sessiongc'),
                    $container->get(MetadataManager::class)
                );
                $plugin->setApplication(Factory::getApplication());

                return $plugin;
            }
        );
    }
};
