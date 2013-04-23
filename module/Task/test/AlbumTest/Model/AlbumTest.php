<?php
// module/Task/test/TaskTest/Model/TaskTest.php:
namespace TaskTest\Model;

use Task\Model\Task;

use PHPUnit_Framework_TestCase;

class TaskTest extends PHPUnit_Framework_TestCase
{
    public function testTaskInitialState()
    {
        $task = new Task();

        $this->assertNull($task->artist, '"artist" should initially be null');
        $this->assertNull($task->id, '"id" should initially be null');
        $this->assertNull($task->title, '"title" should initially be null');
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $task = new Task();
        $data  = array('artist' => 'some artist',
                       'id'     => 123,
                       'title'  => 'some title');

        $task->exchangeArray($data);

        $this->assertSame($data['artist'], $task->artist, '"artist" was not set correctly');
        $this->assertSame($data['id'], $task->id, '"title" was not set correctly');
        $this->assertSame($data['title'], $task->title, '"title" was not set correctly');
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $task = new Task();

        $task->exchangeArray(array('artist' => 'some artist',
                                    'id'     => 123,
                                    'title'  => 'some title'));
        $task->exchangeArray(array());

        $this->assertNull($task->artist, '"artist" should have defaulted to null');
        $this->assertNull($task->id, '"title" should have defaulted to null');
        $this->assertNull($task->title, '"title" should have defaulted to null');
    }
}