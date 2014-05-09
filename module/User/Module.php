<?php
namespace User;

use Zend\Module\Consumer\AutoloaderProvider,
    Zend\EventManager\StaticEventManager;
        
class Module
{
    /**
     * Init function
     *
     * @return void
     */
    public function init()
    {
        // Attach Event to EventManager
        $events = StaticEventManager::getInstance();
        $events->attach('Zend\Mvc\Controller\ActionController', 'dispatch', array($this, 'mvcPreDispatch'), 100); //@todo - Go directly to User\Event\Authentication
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            /*'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),*/
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    /**
     * MVC preDispatch Event
     *
     * @param $event
     * @return mixed
     */
    public function mvcPreDispatch($event) {
        $di = $event->getTarget()->getLocator();
        $auth = $di->get('User\Event\Authentication');

        return $auth->preDispatch($event);
    }
}

/**
 * @uses Zend\Module\Consumer\AutoloaderProvider
 * @uses Zend\EventManager\StaticEventManager
 */
#use Zend\Module\Consumer\AutoloaderProvider,
#    Zend\EventManager\StaticEventManager;


