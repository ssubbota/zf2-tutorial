<?php

namespace Company\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\View\Model\ViewModel;
use Company\Form\CompanyForm;
use Doctrine\ORM\EntityManager;
use Company\Entity\Company;
 
class CompanyController extends AbstractActionController
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }

    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

    public function indexAction() {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {            
            return $this->redirect()->toRoute('home');
        } else {
            return new ViewModel(array(
                'companies' => $this->getEntityManager()->getRepository('Company\Entity\Company')->findAll()
            ));
        }
    }
    
    public function addAction()
    {
        //Beispiel fuer Form mit Annotations
        /*$company    = new Company();
        $builder    = new AnnotationBuilder();
        $form       = $builder->createForm($company);
         
        $request = $this->getRequest();
        if ($request->isPost()){
            $form->bind($company);
            $form->setData($request->getPost());
            if ($form->isValid()){
                print_r($form->getData());
            }
        }
         
        return array('form'=>$form);*/
        
        $form = new CompanyForm();
        $form->get('submit')->setValue('Speichern');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $company = new Company();
            $form->setInputFilter($company->getInputFilter());
            //$form->setData($request->post());
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $company->populate($form->getData());
                $this->getEntityManager()->persist($company);
                $this->getEntityManager()->flush();

                // Redirect to list of companies
                return $this->redirect()->toRoute('company');
            }
        }

        return array('form' => $form);
    }
    
    /*public function updateAction() {
        $entityManager = $this->getEntityManager ();

        $repository = $entityManager->getRepository ( 'Company\Entity\Company' );
        $id = $this->params ()->fromRoute ( 'id' );
        $company = $repository->findOneBy (array('id' => $id));

        $builder = new AnnotationBuilder ( $entityManager );
        $form = $builder->createForm ( $company );

        $form->setHydrator ( new DoctrineHydrator ( $entityManager, 'Company\Entity\Company' ) );
        $form->bind ( $company ); 

        $send = new Element ( 'send' );
        $send->setValue ( 'Create' ); // submit
        $send->setAttributes ( array ('type' => 'submit' ) );
        $form->add ( $send );

        $view = new ViewModel ();
        $view->setVariable ( 'form', $form );
        $view->setVariable ( 'id', $id );
        return $view;
    }*/
    
    public function editAction() {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('company', array('action' => 'add'));
        }
        $company = $this->getEntityManager()->find('Company\Entity\Company', $id);

        $form = new CompanyForm();
        $form->setBindOnValidate(false);
        $form->bind($company);
        $form->get('submit')->setValue('Speichern');
        $request = $this->getRequest();
        if ($request->isPost()) {
                $form->setData($request->getPost());
                if ($form->isValid()) {
                    $form->bindValues();
                    $this->getEntityManager()->flush();

                    // Redirect to list of companies
                    return $this->redirect()->toRoute('company');
                }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction() {
        //$id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('company');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            //$del = $request->getPost()->get('del', 'No');
            $del = $request->getPost('del', 'Nein');
            
            if ($del == 'Ja') {
                //$id = (int) $request->getPost()->get('id');
                $id = (int) $request->getPost('id');
                $company = $this->getEntityManager()->find('Company\Entity\Company', $id);
                if ($company) {
                    $this->getEntityManager()->remove($company);
                    $this->getEntityManager()->flush();
                }
            }
            // Redirect to list of companies
            return $this->redirect()->toRoute('company');
        }

        return array(
            'id' => $id,
            'company' => $this->getEntityManager()->find('Company\Entity\Company', $id)->getArrayCopy()
        );
    }
}

