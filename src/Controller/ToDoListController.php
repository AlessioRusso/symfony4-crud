<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ToDoListController extends AbstractController
{
    /**
     * @Route("/", name="to_do_list")
     */
    public function index()
    {
        return $this->redirectToRoute('tasks');
    }

    /**
     * @Route("create", name="create_task", methods={"POST"})
     */
    public function create(Request $request)
    {
        $title = trim($request->request->get('title'));

        if(empty($title))
        {
            return $this->redirectToRoute('to_do_list');
        }

        $em = $this->getDoctrine()->getManager();
        
        $task = new Task();

        $task->setTitle($title);
        $task->setStatus(False);

        $em->persist($task);

        $em->flush();

        return $this->redirectToRoute('to_do_list');
    }

    /**
     * @Route("switch-status/{id}", name="switch_status")
     */
    public function switchStatus($id)
    {
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(Task::class)->find($id);
        dump($task);
        $task->setStatus(!$task->getStatus());

        $em->persist($task);
        $em->flush();

        return $this->redirectToRoute('to_do_list');
    }

    /**
     * @Route("/delete/{id}", name="delete_task")
     */
    public function delete(Task $task) # this is param converter in symf
    {
       $em = $this->getDoctrine()->getManager();
       $em->remove($task);
       $em->flush();
       return $this->redirectToRoute('to_do_list');
    }


    /**
     * @Route("/tasks", name="tasks")
     */
    public function tasks()
    {
        $tasks = $this->getDoctrine()->getRepository(Task::class)->findBy([], ['id' => 'DESC']);
        return $this->render('index.html.twig', [
            'tasks' => $tasks,
        ]);
    }
}
