<?php

namespace SkautisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SkautisBundle:Default:index.html.twig', array('name' => $name));
    }
}
