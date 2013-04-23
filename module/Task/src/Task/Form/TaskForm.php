<?php
// module/Task/src/Task/Form/TaskForm.php:
namespace Task\Form;

use Zend\Form\Form;

class TaskForm extends Form
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
            'name' => 'priority',
            'options' => array(
                'label' => 'Priority',
                'value_options' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3'
                ),
            ),
            'attributes' => array(
                'value' => '1' //set selected to '1'
            )
        ));
		
		
        $this->add(array(
            'name' => 'artist',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Artist',
            ),
        ));
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Title',
            ),
        ));
		
		$this->add(array(
            'name' => 'due_date',
            'attributes' => array(
                'type'  => 'Date',
            ),
            'options' => array(
                'label' => 'Due date',
            ),
        ));
		
		
		
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}