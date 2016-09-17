<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\RouterInterface;

class ListUserAdvertsController extends Controller
{
    /**
     * @Route("list_user_ads")
     */
    public function listAdvertAction()
    {
    	// check if user present (logged in)
    	$user = $this->getUser();
    	if($user) {
    		$repository = $this->getDoctrine()->getRepository('AppBundle:Advert');
    		$user_id = $user->getId();
    		// get all adverts posted by user
    		$adverts = $repository->findByuserId($user_id);
    		return $this->render('AppBundle:ListUserAdverts:list_advert.html.twig', ['adverts' => $adverts]);
    	}
    	else {
    		return $this->redirectToRoute('homepage');
    	}
    }

}
