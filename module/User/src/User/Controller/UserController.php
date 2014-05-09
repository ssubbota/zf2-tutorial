<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use User\Form\Login as LoginForm;

//Doctrine Stuff
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

class UserController extends AbstractActionController {

    private $entityManager;

    public function getEntityManager() {
        if (!$this->entityManager) {
            $paths = array (
                    realpath ( dirname ( __FILE__ ) . '/../Entity' )
            );
            $isDevMode = true;
            // the connection configuration
            $dbParams = array (
                    'driver' => 'pdo_mysql',
                    'user' => 'root',
                    'password' => 'scito#tec2012',
                    'dbname' => 'zf2-tutorial'
            );
        $config = Setup::createAnnotationMetadataConfiguration ( $paths, $isDevMode, null, null, false );
        $this->entityManager = EntityManager::create ( $dbParams, $config );
        }
        return $this->entityManager;
    }

    public function updateAction() {
        $entityManager = $this->getEntityManager ();

        $repository = $entityManager->getRepository ( 'User\Entity\User' );
        $id = $this->params ()->fromRoute ( 'id' );
        $user = $repository->findOneBy (array('id' => $id));

        $builder = new AnnotationBuilder ( $entityManager );
        $form = $builder->createForm ( $user );

        $form->setHydrator ( new DoctrineHydrator ( $entityManager, 'User\Entity\User' ) );
        $form->bind ( $user ); 

        /*$send = new Element ( 'send' );
        $send->setValue ( 'Create' ); // submit
        $send->setAttributes ( array ('type' => 'submit' ) );
        $form->add ( $send );*/

        $view = new ViewModel ();
        $view->setVariable ( 'form', $form );
        $view->setVariable ( 'id', $id );
        return $view;
    }
    
    /**
     * Index Action
     */
    public function indexAction()
    {
        //@todo - Implement indexAction
    }

    /**
     * Login Action
     *
     * @return array
     */
    public function loginAction()
    {
        $form = new LoginForm();
        $request = $this->getRequest();

        if ($request->isPost() && $form->isValid($request->post()->toArray())) {
            $uAuth = $this->getLocator()->get('User\Controller\Plugin\UserAuthentication'); //@todo - We must use PluginLoader $this->userAuthentication()!!
            $authAdapter = $uAuth->getAuthAdapter();

            $authAdapter->setIdentity($form->getValue('username'));
            $authAdapter->setCredential($form->getValue('password'));

            \Zend\Debug::dump($uAuth->getAuthService()->authenticate($authAdapter));
        }

        return array('loginForm' => $form);
    }

    /**
     * Logout Action
     */
    public function logoutAction()
    {
        $this->getLocator()->get('User\Controller\Plugin\UserAuthentication')->clearIdentity(); //@todo - We must use PluginLoader $this->userAuthentication()!!
    }

}

