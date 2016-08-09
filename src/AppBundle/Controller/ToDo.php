<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ToDo extends Controller
{
    /**
     * @Route("/todo")
     */
    public function createList()
    {
        $pagetitle = "To Do List";

        $todolist = array(
            1 => array('id' => 1, 'title' => 'test'),
            2 => array('id' => 2, 'title' => 'ookeentest'),
        );


        return $this->render('todolist.html.twig', array(
            'pagetitle' => $pagetitle,
            'todolist'  => $todolist,
        ));
    }
}