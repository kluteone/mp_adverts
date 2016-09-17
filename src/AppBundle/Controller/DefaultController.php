<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        //database fetch for all adverts with usernames include (dirty logic, should rework)
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT a.title, a.description, a.createDate, u.name
             FROM AppBundle:Advert a
             LEFT JOIN AppBundle:User u with  u.id = a.userId
             ORDER BY a.createDate DESC'
        );

        $adverts  = $query->getResult();

        //check if user is logged in by getting curent user
        $user = $this->getUser();
        $is_logged_in = false;
        if(isset($user)) {
            $is_logged_in = true;
        }

        //assigning variables and rendering view
        return $this->render('AppBundle:Home:index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'adverts' => $adverts,
            'is_logged_in' => $is_logged_in
        ]);
    }
}
