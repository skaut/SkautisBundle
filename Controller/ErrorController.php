<?php

namespace SkautisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Skautis error controller
 * Zobrazeni informace pri neosetrene vyjimce \Skautis\Exception
 */
class ErrorController extends Controller
{
    /**
     * Zobrazi error
     */
    public function errorAction() {
        $response =  $this->render("SkautisBundle:Controller/Error:index.html.twig");
        $response->setStatusCode(500);

        return $response;
    }
}