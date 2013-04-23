<?php
namespace Task\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Task\Model\Task;
use Task\Form\TaskForm;
use Task\Form\FilterForm;

class TaskController extends AbstractActionController
{
    protected $taskTable;

    public function indexAction()
    {        
		/*
		if ($this->zfcUserAuthentication()->hasIdentity()) {
			echo 'Have identiti';
			 echo $this->zfcUserAuthentication()->getIdentity()->getEmail();
    //get the user_id of the user
    echo $this->zfcUserAuthentication()->getIdentity()->getId();
    //get the username of the user
    echo $this->zfcUserAuthentication()->getIdentity()->getUsername();
    //get the display name of the user
    echo $this->zfcUserAuthentication()->getIdentity()->getDisplayname();
		}
		else
		{
			echo 'NOT have identiti';
		}
		*/
		
		
		
		$paginator = $this->getTaskTable()->fetchAll(true);
		$paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
		$paginator->setItemCountPerPage(3);
		
		
		$form  = new FilterForm();
		return new ViewModel(array(
			'paginator' => $paginator,
			 'form' => $form,
		));
    }

    public function addAction()
    {
        $form = new TaskForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $task = new Task();
            $form->setInputFilter($task->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $task->exchangeArray($form->getData());
                $this->getTaskTable()->saveTask($task);

                // Redirect to list of tasks
                return $this->redirect()->toRoute('task');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('task', array(
                'action' => 'add'
            ));
        }
        $task = $this->getTaskTable()->getTask($id);

        $form  = new TaskForm();
        $form->bind($task);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($task->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getTaskTable()->saveTask($form->getData());

                // Redirect to list of tasks
                return $this->redirect()->toRoute('task');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('task');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getTaskTable()->deleteTask($id);
            }

            // Redirect to list of tasks
            return $this->redirect()->toRoute('task');
        }

        return array(
            'id'    => $id,
            'task' => $this->getTaskTable()->getTask($id)
        );
    }

    public function getTaskTable()
    {
        if (!$this->taskTable) {
            $sm = $this->getServiceLocator();
            $this->taskTable = $sm->get('Task\Model\TaskTable');
        }
        return $this->taskTable;
    }
}