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
     * @ORM\Column(type="string")
     * @Annotation\Options({"label": "Todo: ", "name": "task"})
     */
    protected $task;

    /**
     * @ORM\Column(type="boolean")
     * @Annotation\Attributes({"type": "hidden"})
     * @Annotation\AllowEmpty(true)
     * @Annotation\Required(false)
     */
    protected $done;

    public function __construct()
    {
        $this->done = 0;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTask()
    {
        return $this->task;
    }

    public function getDone()
    {
        return $this->done;
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

    public function setDone($done)
    {
        $this->done = $done;
        return $this;
    }
}
