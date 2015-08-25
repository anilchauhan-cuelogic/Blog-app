<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DashboardController extends Controller
{
    public function indexAction()
    {
        if(!$this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')){    
            throw new AccessDeniedException("Error Processing Request");
        }

        return $this->render('AppBundle:Dashboard:index.twig.html');
    }
}