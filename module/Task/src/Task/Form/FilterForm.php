<?php

namespace Task\Form;

use Zend\Form\Form;

class FilterForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('task');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
		
		$this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'filter',
            'options' => array(
                'label' => null,
                'value_options' => array(
                    '1' => ' - show all tasks -',
                    '2' => 'show late tasks',
                    '3' => 'show important tasks'
                ),
            ),
            'attributes' => array(
                'value' => '1' //set selected to '1'
            )
        ));
		/*
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'dd',
                'id' => 'submitbutton',
            ),
        ));
		*/
		
    }
}