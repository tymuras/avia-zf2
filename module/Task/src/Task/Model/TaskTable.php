<?php
namespace Task\Model;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class TaskTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
	
	public function fetchAll($paginated=false)
	{
		if($paginated) 
		{
			$select = new Select('task');
			$resultSetPrototype = new ResultSet();
			$resultSetPrototype->setArrayObjectPrototype(new Task());
			$paginatorAdapter = new DbSelect(
			$select,
			$this->tableGateway->getAdapter(),
			$resultSetPrototype
			);
			$paginator = new Paginator($paginatorAdapter);
			return $paginator;
		}
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

    public function getTask($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveTask(Task $task)
    {
        $data = array(
            'artist' => $task->artist,
            'title'  => $task->title,
			'due_date'  => $task->due_date,
			'priority'  => $task->priority,
        );

        $id = (int)$task->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getTask($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteTask($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}