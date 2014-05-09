<?php

namespace Branch\Form;

use Zend\Form\Form;

//implements ServiceManagerAwareInterface

class BranchForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('branch');
        
        // eine Klasse zum <form> Tag hinzufuegen:
        $this->setAttribute('class', 'form-horizontal');
        
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'company_id',
            'type' => 'Select',
            'options' => array(
                'label' => 'Firma wählen ',
                'options' => array('1' => 'Firma 1', '2' => 'Firma 2')
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Name der Filiale',
            ),
            'attributes' => array(
                'placeholder' => 'Name der Filiale',
                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'type' => 'email',
            'options' => array(
                'label' => 'E-Mail',
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
    }

}
