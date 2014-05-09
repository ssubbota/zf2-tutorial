<?php

namespace Company\Form;

 use Zend\Form\Form;

 class CompanyForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('company');
         
         // eine Klasse zum <form> Tag hinzufuegen:
         $this->setAttribute('class', 'form-horizontal');
        
         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'name',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Firmenname ',
             ),
             'attributes' => array(
                'placeholder' => 'Firmenname',
                'class' => 'form-control',
            ),
         ));
         $this->add(array(
             'name' => 'email',
             'type' => 'Text',
             'options' => array(
                 'label' => 'E-Mail ',
             ),
             'attributes' => array(
                'placeholder' => 'E-Mail',
                'class' => 'form-control',
            ),
         ));
         $this->add(array(
             'name' => 'phone',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Telefon ',
                 'bootstrap' => array(
                    'help' => array(
                        'style' => 'block',
                        'content' => 'Telefon'
                    ),
                    'prepend' => array('$'),
                    'append' => array('¢'),
                ),
             ),
             'attributes' => array(
                'placeholder' => 'Telefon',
                'class' => 'form-control',
            ),
         ));
         $this->add(array(
            'name' => 'street',
            'type' => 'Text',
            'options' => array(
                'label' => 'Strasse ',
            ),
            'attributes' => array(
                'placeholder' => 'Strasse',
                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'zip',
            'type' => 'Text',
            'options' => array(
                'label' => 'PLZ ',
            ),
            'attributes' => array(
                'placeholder' => 'PLZ',
                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'place',
            'type' => 'Text',
            'options' => array(
                'label' => 'Ort ',
            ),
            'attributes' => array(
                'placeholder' => 'Ort',
                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'web',
            'type' => 'Text',
            'options' => array(
                'label' => 'Web ',
            ),
            'attributes' => array(
                'placeholder' => 'Web',
                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'description',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Beschreibung ',
            ),
            'attributes' => array(
                'placeholder' => 'Beschreibung',
                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Speichern',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary'
            ),
        ));
         
        /*$this->add(array(
            'name' => 'reset',
            'attributes' => array(
                'type' => 'reset',
                'value' => 'Abbrechen',
                'class' => 'btn'
            ),
            'options' => array(
                'bootstrap' => array(
                    'style' => 'inline',
                ),
            ),
        ));*/
     }
 }

