<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Task Controllers provide a simple and usefull task list. Full ajax.
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="task")
     */
    public function getTaskList()
    {
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }
}
