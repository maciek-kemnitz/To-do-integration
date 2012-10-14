<?php

namespace ZL\IntegrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ZL\IntegrationBundle\Entity\User;
use ZL\IntegrationBundle\Form\User\LoginUser;

class HomePageController extends Controller
{
    public function loginAction(Request $request)
    {
		$form = $this->createForm(new LoginUser(), new User());
		
		if ($request->getMethod() == 'POST') 
		{
			
            $form->bindRequest($request);
			
            if ($form->isValid()) 
			{
			
				$user = $form->getData();
				
                $session  = $this->get("session");
				$session->set('user', $user);

				$url = $this->generateUrl("main");
				return $this->redirect($url);
            }
			
		}
		
        return $this->render('ZLIntegrationBundle:HomePage:login.html.twig', array('form' => $form->createView()));
    }
	
	public function mainAction()
    {
        return $this->render('ZLIntegrationBundle:HomePage:main.html.twig');
    }
}
