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

        $todolist = array(
            1 => array('title' => 'test'),
            2 => array('title' => 'ookeentest'),
        );


        return $this->render('todolist.html.twig', array(
            'todolist' => $todolist,
        ));
    }
}