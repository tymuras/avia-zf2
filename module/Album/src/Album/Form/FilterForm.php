<?php

namespace Album\Form;

use Zend\Form\Form;

class FilterForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('album');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
		
		$this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'filetr',
            'options' => array(
                'label' => 'Filter',
                'value_options' => array(
                    '1' => 'Today task',
                    '2' => 'Late task',
                    '3' => 'Important tasks'
                ),
            ),
            'attributes' => array(
                'value' => '1' //set selected to '1'
            )
        ));
		
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Filter',
                'id' => 'submitbutton',
            ),
        ));
    }
}