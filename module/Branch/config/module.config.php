<?php
namespace Branch;

return array(
     'controllers' => array(
         'invokables' => array(
             'Branch\Controller\Branch' => 'Branch\Controller\BranchController',
         ),
     ),
    
     'router' => array(
         'routes' => array(
             'branch' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/branch[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Branch\Controller\Branch',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'branch' => __DIR__ . '/../view',
         ),
     ),
    
    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    )
 );