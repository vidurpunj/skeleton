<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Division\Controller\Division' => 'Division\Controller\DivisionController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'division' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/division[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Division\Controller\Division',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),


    'view_manager' => array(
        'template_path_stack' => array(
            'division' => __DIR__ . '/../view',
        ),
    ),
);