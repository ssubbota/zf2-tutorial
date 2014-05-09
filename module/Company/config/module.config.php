<?php
namespace Company;

return array(
     'controllers' => array(
         'invokables' => array(
             'Company\Controller\Company' => 'Company\Controller\CompanyController',
         ),
     ),
    
     'router' => array(
         'routes' => array(
             'company' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/company[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Company\Controller\Company',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'company' => __DIR__ . '/../view',
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