<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Type;
use Zend\Form\Annotation;

/** @ORM\Entity */
class Todo {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue
    * @ORM\Column(type="integer")
    * @Annotation\Attributes({"type": "hidden"})
    */
    protected $id;

    /**
     * @ORM\Column(name="task", type="string")
     * @Annotation\Options({"label": "Todo: ", "name": "task"})
     */
    protected $task;

    public function getId()
    {
        return $this->id;
    }

    public function getTask()
    {
        return $this->task;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setTask($task)
    {
        $this->task = $task;
        return $this;
    }
}
