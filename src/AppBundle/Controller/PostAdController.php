<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Advert;
use AppBundle\Form\AdvertType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostAdController extends Controller
{
    /**
     * @Route("post_ad")
     */
    public function postAdAction(Request $request)
    {   
    	$securityContext = $this->container->get('security.authorization_checker');

    	// check if user is logged in
    	if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {    

    		$advert = new Advert();
    		$form = $this->createForm(AdvertType::class, $advert);
    		$form->handleRequest($request);
            
    		if ($form->isSubmitted() && $form->isValid()) {

    			$advert->setCreateDate(new \DateTime());
                $user_id = $this->getUser()->getId();
    			$advert->setUserId($user_id);

            	// Save
    			$em = $this->getDoctrine()->getManager();
    			$em->persist($advert);
    			$em->flush();
    			return $this->redirectToRoute('homepage');
    		}
    		return $this->render('AppBundle:PostAd:post_ad.html.twig', [
    			'form' => $form->createView(),
    			]);
        }
        else {
    		return $this->redirectToRoute('login');
        }
    }

}
