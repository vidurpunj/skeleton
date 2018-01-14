<?php

namespace AlbumImage;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use AlbumImage\Model\AlbumImage;
use AlbumImage\Model\AlbumImageTable;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'AlbumImage\Model\AlbumImageTable' => function ($sm) {
                    $tableGateway = $sm->get('AlbumImageTableGateway');
                    $table = new AlbumImageTable($tableGateway);
                    return $table;
                },
                'AlbumImageTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new AlbumImage());
                    return new TableGateway('album_images', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}
