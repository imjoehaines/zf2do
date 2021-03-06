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
     * @Annotation\Attributes({"placeholder": "Add a new task...", "maxlength": "250"})
     * @Annotation\Filter({"name": "StringTrim"})
     * @Annotation\Validator({"name": "StringLength", "options": {"min": 1, "max": 250}})
     * @Annotation\ErrorMessage("You did it wrong, try again")
     */
    protected $task;

    /**
     * @ORM\Column(type="boolean")
     * @Annotation\Exclude()
     */
    protected $done;

    public function __construct()
    {
        $this->done = 0;
    }

    public function markComplete()
    {
        $this->done = 1;
        return $this;
    }

    public function markIncomplete()
    {
        $this->done = 0;
        return $this;
    }

    public function isDone()
    {
        return $this->done ? true : false;
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
