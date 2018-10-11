<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\{Task};
use App\Form\{TaskType};

/**
 * Task Controllers provide a simple and usefull task list. Full ajax.
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="task_list", methods={"GET"})
     */
    public function getTaskList()
    {

        // Task widget
        $addTaskForm =  $this->createForm(TaskType::class)->createView();
        
        $tasksList = $this->getDoctrine()
                          ->getRepository(Task::class)
                          ->getTasksList();

        return $this->render('task/partial/_task-list-widget.html.twig', [
            'TaskList' => $tasksList,
            'AddTaskForm' => $addTaskForm,
        ]);
    }


    /**
     * @Route("/tasks/add", name="task_add", methods={"POST"})
     */
    public function taskAdd(Request $request)
    {
        $task = new Task();
        $form =  $this->createForm(TaskType::class, $task)
                      ->handleRequest($request);
        
        if(!$form->isValid()){
            $this->addFlash('danger','Une erreur est survenue : '.$form->getErrors()[0]);
            return $this->redirectToRoute('homepage');
        }

        $task->setUser($this->getUser());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($task);
        $entityManager->flush();

        return $this->redirectToRoute('homepage');
    }


    /**
     * @Route("/tasks/{id}/delete", name="task_delete", methods={"GET"}, requirements={"id"="\d+", "page"="\d+"})
     */
    public function taskDelete(Task $task)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($task);
        $entityManager->flush();

        return new Response('Task correctly removed');
    }

    /**
     * @Route("/tasks/{id}/update/status", name="task_update_status", methods={"GET"}, requirements={"id"="\d+", "page"="\d+"})
     */
    public function taskUpdateStatus(Task $task)
    {
        $newTaskStatus = ($task->getCompleted()) ? false : true;
        $task->setCompleted($newTaskStatus);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($task);
        $entityManager->flush();

        $stringStatus = ($newTaskStatus) ? 'Completed' : 'In progress';
        return new Response('New task['.$task->getID().'] completed status : ' . $stringStatus );
    }
}
