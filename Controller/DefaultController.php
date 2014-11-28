<?php

namespace SkautisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

	$skautIS = $this->get('skautis');


        return $skautis->getLoginUrl();
    }
}
