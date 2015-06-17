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
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $todo = new Todo();
        $builder = new AnnotationBuilder($objectManager);

        $form = $builder->createForm($todo);
        $form->setHydrator(new DoctrineHydrator($objectManager,'\Application\Entity\Todo'));
        $form->bind($todo);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $objectManager->persist($todo);
                $objectManager->flush();

                return $this->redirect()->toRoute('home');
            }
        }

        $repository = $objectManager->getRepository('\Application\Entity\Todo');

        $tasks = $repository->findAll();

        return new ViewModel([
            'form' => $form,
            'todos' => $tasks,
        ]);
    }
}
