<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{
    /**
     * @Route("/register")
     */
    public function registerAction(Request $request)
    {
    	// Create user
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        	// Encode the new users password
            $encoder = $this->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            // Set their role
            $user->setRole('ROLE_USER');
            // Save
        	$em = $this->getDoctrine()->getManager();
        	$em->persist($user);
        	$em->flush();
        	return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:Registration:register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
