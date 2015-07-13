<?php
/**
 * Created by PhpStorm.
 * User: Jindra
 * Date: 13. 7. 2015
 * Time: 17:56
 */

namespace SkautisBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ErrorController extends Controller
{
    public function errorAction() {
        $response =  $this->render("SkautisBundle:Controller/Error:index.html.twig");
        $response->setStatusCode(500); //TODO external service error?

        return $response;
    }
}