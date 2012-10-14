<?php

namespace ZL\IntegrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ZLIntegrationBundle:Default:index.html.twig', array('name' => $name));
    }
}
