<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Giftcard\Controller\Giftcard' => 'Giftcard\Controller\GiftcardController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'giftcard' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/giftcard[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Giftcard\Controller\Giftcard',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),


    'view_manager' => array(
        'template_path_stack' => array(
            'giftcard' => __DIR__ . '/../view',
        ),
    ),
);