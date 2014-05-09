<?php
namespace User;

return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'user' => 'User\Controller\UserController'
            ),
            'user' => array(
                'parameters' => array(
                    'broker' => 'Zend\Mvc\Controller\PluginBroker'
                )
            ),
            'User\Event\Authentication' => array(
                'parameters' => array(
                    'userAuthenticationPlugin' => 'User\Controller\Plugin\UserAuthentication',
                    'aclClass'                 => 'User\Acl\Acl'
                )
            ),
            'User\Acl\Acl' => array(
                'parameters' => array(
                    'config' => include __DIR__ . '/acl.config.php'
                )
            ),
            'User\Controller\Plugin\UserAuthentication' => array(
                'parameters' => array(
                    'authAdapter' => 'Zend\Authentication\Adapter\DbTable'
                )
            ),
            'Zend\Authentication\Adapter\DbTable' => array(
                'parameters' => array(
                    'zendDb' => 'Zend\Db\Adapter\Mysqli',
                    'tableName' => 'users',
                    'identityColumn' => 'email',
                    'credentialColumn' => 'password',
                    'credentialTreatment' => 'SHA1(CONCAT(?, "secretKey"))'
                )
            ),
            'Zend\Db\Adapter\Mysqli' => array(
                'parameters' => array(
                    'config' => array(
                        'host' => 'localhost',
                        'username' => 'username',
                        'password' => 'password',
                        'dbname' => 'dbname',
                        'charset' => 'utf-8'
                    )
                )
            ),
            'Zend\Mvc\Controller\PluginLoader' => array(
                'parameters' => array(
                    'map' => array(
                        'userAuthentication' => 'User\Controller\Plugin\UserAuthentication'
                    )
                )
            ),
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'options' => array(
                        'script_paths' => array(
                            'user' => __DIR__ . '/../views'
                        )
                    )
                )
            )
        )
    ),
    'routes' => array(
        'login' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route'    => '/login',
                'defaults' => array(
                    'controller' => 'user',
                    'action'     => 'login',
                )
            )
        )
    )
);
/*
return array(
     'controllers' => array(
         'invokables' => array(
             'User\Controller\User' => 'User\Controller\UserController',
         ),
     ),
    
     'router' => array(
         'routes' => array(
             'user' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/user[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'User\Controller\User',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'user' => __DIR__ . '/../view',
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
 );*/