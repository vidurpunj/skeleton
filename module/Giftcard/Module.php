<?php

namespace Giftcard;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Giftcard\Model\Giftcard;
use Giftcard\Model\GiftcardTable;
//Add Giftcard & GiftcardModel


class Module  implements AutoloaderProviderInterface, ConfigProviderInterface{
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
                'Giftcard\Model\GiftcardTable' => function ($sm) {
                    $tableGateway = $sm->get('GiftcardTableGateway');
                    $table = new GiftcardTable($tableGateway);
                    return $table;
                },
                'GiftcardTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Giftcard());
                    return new TableGateway('giftcard', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}