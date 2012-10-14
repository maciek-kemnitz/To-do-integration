<?php

namespace ZL\IntegrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomePageController extends Controller
{
    public function loginAction()
    {
        return $this->render('ZLIntegrationBundle:HomePage:login.html.twig');
    }
	
	public function mainAction()
    {
        return $this->render('ZLIntegrationBundle:HomePage:main.html.twig');
    }
}
