<?php
// module/Task/test/TaskTest/Model/TaskTableTest.php:
namespace Task\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;

class TaskTableTest extends PHPUnit_Framework_TestCase
{
    public function testFetchAllReturnsAllTasks()
    {
        $resultSet        = new ResultSet();
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
                                           array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('select')
                         ->with()
                         ->will($this->returnValue($resultSet));

        $taskTable = new TaskTable($mockTableGateway);

        $this->assertSame($resultSet, $taskTable->fetchAll());
    }
    public function testCanRetrieveAnTaskByItsId()
    {
        $task = new Task();
        $task->exchangeArray(array('id'     => 123,
                                    'artist' => 'The Military Wives',
                                    'title'  => 'In My Dreams'));

        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Task());
        $resultSet->initialize(array($task));

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('select')
                         ->with(array('id' => 123))
                         ->will($this->returnValue($resultSet));

        $taskTable = new TaskTable($mockTableGateway);

        $this->assertSame($task, $taskTable->getTask(123));
    }

    public function testCanDeleteAnTaskByItsId()
    {
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('delete'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('delete')
                         ->with(array('id' => 123));

        $taskTable = new TaskTable($mockTableGateway);
        $taskTable->deleteTask(123);
    }

    public function testSaveTaskWillInsertNewTasksIfTheyDontAlreadyHaveAnId()
    {
        $taskData = array('artist' => 'The Military Wives', 'title' => 'In My Dreams');
        $task     = new Task();
        $task->exchangeArray($taskData);

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('insert')
                         ->with($taskData);

        $taskTable = new TaskTable($mockTableGateway);
        $taskTable->saveTask($task);
    }

    public function testSaveTaskWillUpdateExistingTasksIfTheyAlreadyHaveAnId()
    {
        $taskData = array('id' => 123, 'artist' => 'The Military Wives', 'title' => 'In My Dreams');
        $task     = new Task();
        $task->exchangeArray($taskData);

        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Task());
        $resultSet->initialize(array($task));

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway',
                                           array('select', 'update'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('select')
                         ->with(array('id' => 123))
                         ->will($this->returnValue($resultSet));
        $mockTableGateway->expects($this->once())
                         ->method('update')
                         ->with(array('artist' => 'The Military Wives', 'title' => 'In My Dreams'),
                                array('id' => 123));

        $taskTable = new TaskTable($mockTableGateway);
        $taskTable->saveTask($task);
    }

    public function testExceptionIsThrownWhenGettingNonexistentTask()
    {
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Task());
        $resultSet->initialize(array());

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('select')
                         ->with(array('id' => 123))
                         ->will($this->returnValue($resultSet));

        $taskTable = new TaskTable($mockTableGateway);

        try
        {
            $taskTable->getTask(123);
        }
        catch (\Exception $e)
        {
            $this->assertSame('Could not find row 123', $e->getMessage());
            return;
        }

        $this->fail('Expected exception was not thrown');
    }
}