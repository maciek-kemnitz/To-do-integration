<?php

namespace ZL\IntegrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomePageController extends Controller
{
    public function loginAction()
    {
        return $this->render('ZLIntegrationBundle:HomePage:login.html.twig');
    }
}
