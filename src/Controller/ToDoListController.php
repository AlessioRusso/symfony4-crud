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
        return $this->render('index.html.twig');
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
        
        $task = new Task;

        $task->setTitle($title);
        $task->setStatus(false);

        $em->persist($task);

        $em->flush();

        return $this->redirectToRoute('to_do_list');
    }

    /**
     * @Route("switch-status/{id}", name="switch_status")
     */
    public function switchStatus($id)
    {
        exit('to do: switch status'.$id);
    }

    /**
     * @Route("/delete/{id}", name="delete_task")
     */
    public function delete($id)
    {
        exit('to do: delete a task '.$id);
    }
}
