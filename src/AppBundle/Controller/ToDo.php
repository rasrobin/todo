<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\ToDoList;
use AppBundle\Entity\Item;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ToDo extends Controller
{
    /**
     * @Route("/todo/list/{listId}")
     */
    public function showList($listId, Request $request)
    {
        $msgs = array();

        //formulier maken
        $item = new Item();
        $item->setName('Naam van het item');

        $form = $this->createFormBuilder($item)
            ->add('name', TextType::class, array('label' => 'Naam'))
            ->add('save', SubmitType::class, array('label' => 'Item toevoegen'))
            ->getForm();

        //formulier afhandelen
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $item = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $msgs[] = "Item toegevoegd";
        }


        // lijst ophalen op basis van ID
        $list = $this->getDoctrine()
            ->getRepository('AppBundle:ToDoList')
            ->find($listId);

        if (!$list) {
            //voor consumenten mooier afhandelen dan dit:
            throw $this->createNotFoundException(
                'Geen To Do List gevonden met ID '.$listId
            );
        }

        return $this->render('todolist.html.twig', array(
            'list'      => $list,
            'msgs'      => $msgs,
            'form'      => $form->createView(),

            //lelijke manier om toch maar even verder te gaan
            'baseurl'   => 'http://todo/web/app_dev.php/todo/'
        ));
    }

    /**
     * @Route("/todo/action/delete/{id}")
     */
    public function deleteListItem($id)
    {
        $em     = $this->getDoctrine()->getManager();
        $item   = $this->getDoctrine()
            ->getRepository('AppBundle:Item')
            ->find($id);

        if (!$item) {
            //voor consumenten mooier afhandelen dan dit:
            throw $this->createNotFoundException(
                'Geen item gevonden met ID ' . $id
            );
        }

        $em->remove($item);
        $em->flush();

        return $this->showList();
    }
}