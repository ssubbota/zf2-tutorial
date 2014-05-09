<?php

namespace Branch\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Branch\Form\BranchForm,
    Doctrine\ORM\EntityManager,
    Branch\Entity\Branch;

class BranchController extends AbstractActionController {

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

    /* public function getEntityManager() {
      if (null === $this->em) {
      $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
      }
      return $this->em;
      } */
    
    protected function getNumberOptions() {
        // or however you want to load the data in
        //$mapper = $this->getServiceManager()->get('NumberMapper');
        //return $mapper->getList();
        
        //$mapper = $this->getEntityManager()->getRepository('Company\Entity\Company')->findAll();
        //return $mapper[0];
        return new ViewModel(array(
            'companies' => $this->getEntityManager()->getRepository('Company\Entity\Company')->findAll()
        ));
    }

    public function indexAction() {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {            
            return $this->redirect()->toRoute('home');
        } else {    
            return new ViewModel(array(
                'branches' => $this->getEntityManager()->getRepository('Branch\Entity\Branch')->findAll()
            ));
        }
    }

    public function addAction() {
        $companies = $this->getEntityManager()->getRepository('Company\Entity\Company')->findAll();
        
        $form = new BranchForm();

        $form->get('submit')->setValue('Speichern');

        //$form->get('company_id')->setAttribute('options', array('KEY' => 'VALUE', 'KEY1' => 'VALUE1'));
        
        //$form->get('company_id')->setAttribute('options', $this->getNumberOptions());
        //$this->get('number')->setAttribute('options', $this->getNumberOptions());

        $request = $this->getRequest();
        if ($request->isPost()) {
            $branch = new Branch();
            $form->setInputFilter($branch->getInputFilter());
            //$form->setData($request->post());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $branch->populate($form->getData());
                $this->getEntityManager()->persist($branch);
                $this->getEntityManager()->flush();

                // Redirect to list of branchs
                return $this->redirect()->toRoute('branch');
            }
        }

        return array('form' => $form, 'companies' => $companies);

        /* if ($request->isPost()) {
          $branch = new Branch();
          $form->setInputFilter($branch->getInputFilter());
          $form->setData($request->getPost());

          if ($form->isValid()) {
          $branch->exchangeArray($form->getData());
          $this->getBranchTable()->saveBranch($branch);

          // Redirect to list of branchs
          return $this->redirect()->toRoute('branch');
          }
          }
          return array('form' => $form); */
    }

    public function editAction() {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('branch', array('action' => 'add'));
        }
        $branch = $this->getEntityManager()->find('Branch\Entity\Branch', $id);

        $form = new BranchForm();
        $form->setBindOnValidate(false);
        $form->bind($branch);
        $form->get('submit')->setAttribute('label', 'Edit');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();

                // Redirect to list of branches
                return $this->redirect()->toRoute('branch');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
            'companies' => $this->getEntityManager()->getRepository('Company\Entity\Company')->findAll()
        );
    }

    public function deleteAction() {
        //$id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('branch');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            //$del = $request->getPost()->get('del', 'No');
            $del = $request->getPost('del', 'Nein');

            if ($del == 'Ja') {
                //$id = (int) $request->getPost()->get('id');
                $id = (int) $request->getPost('id');
                $branch = $this->getEntityManager()->find('Branch\Entity\Branch', $id);
                if ($branch) {
                    $this->getEntityManager()->remove($branch);
                    $this->getEntityManager()->flush();
                }
            }

            // Redirect to list of albums
            /* return $this->redirect()->toRoute('default', array(
              'controller' => 'album',
              'action' => 'index',
              )); */
            // Redirect to list of albums
            return $this->redirect()->toRoute('branch');
        }

        return array(
            'id' => $id,
            'branch' => $this->getEntityManager()->find('Branch\Entity\Branch', $id)->getArrayCopy()
        );
    }

}
