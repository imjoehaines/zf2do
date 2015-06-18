<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Application\Entity\Todo;

class TaskUpdateController extends AbstractActionController
{
    public function completeAction()
    {
        $id = $this->params()->fromRoute('id');

        // redirect back to home if not giving an id
        if (!$id) return $this->redirect()->toRoute('home');

        // grab the correct todo object
        $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $todo = $entityManager->getReference('Application\Entity\Todo', $id);

        // toggle complete status
        if ($todo->isDone()) {
            $todo->markIncomplete();
        } else {
            $todo->markComplete();
        }

        $entityManager->flush();

        return $this->redirect()->toRoute('home');
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');

        // redirect back to home if not giving an id
        if (!$id) return $this->redirect()->toRoute('home');

        // grab the correct todo object
        $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $todo = $entityManager->getReference('Application\Entity\Todo', $id);

        $entityManager->remove($todo);
        $entityManager->flush();

        return $this->redirect()->toRoute('home');
    }
}
