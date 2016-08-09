<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\ToDoList;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ToDo extends Controller
{
    /**
     * @Route("/todo")
     */
    public function showList()
    {
        $listId     = 1;

        $list = $this->getDoctrine()
            ->getRepository('AppBundle:ToDoList')
            ->find($listId);

        if (!$list) {
            throw $this->createNotFoundException(
                'Geen To Do List gevonden met ID '.$listId
            );
        }

        return $this->render('todolist.html.twig', array(
            'list'      => $list,
        ));
    }
}