<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'AlbumImage\Controller\AlbumImage' => 'AlbumImage\Controller\AlbumImageController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'album_image' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/album_image[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'AlbumImage\Controller\AlbumImage',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),


    'view_manager' => array(
        'template_path_stack' => array(
            'album_image' => __DIR__ . '/../view',
        ),
    ),
);