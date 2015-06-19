<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use Application\Entity\Todo;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $filter = $this->params()->fromRoute('filter');
        if (!$filter) $filter = 'all';

        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $todo = new Todo();
        $builder = new AnnotationBuilder($objectManager);

        $form = $builder->createForm($todo);
        $form->setHydrator(new DoctrineHydrator($objectManager,'\Application\Entity\Todo'));
        $form->bind($todo);

        $request = $this->getRequest();
        if ($request->isPost() && isset($request->getPost()->task)) {
            $form->setData(['task' => $request->getPost()->task]);
            if ($form->isValid()) {
                $objectManager->persist($todo);
                $objectManager->flush();

                return $this->redirect()->toRoute('home');
            }
        }

        $repository = $objectManager->getRepository('\Application\Entity\Todo');

        switch ($filter) {
            case 'all':
                $filters = [];
                break;
            case 'complete':
                $filters = ['done' => 1];
                break;
            case 'incomplete':
                $filters = ['done' => 0];
                break;
            default:
                throw new Exception('Error processing request -- invalid filter given');
                
        }

        $tasks = $repository->findBy($filters, ['id' => 'DESC']);

        return new ViewModel([
            'form' => $form,
            'todos' => $tasks,
            'completedItems' => $repository->findBy(['done' => 1]),
            'filter' => $filter,
        ]);
    }
}
