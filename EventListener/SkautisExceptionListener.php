<?php

namespace SkautisBundle\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Listener pro zpracovani neosetrenych \Skautis\Exception
 */
class SkautisExceptionListener
{
    /**
     * Kontrola zda tento listener obsluhuje dany typ exceptionu
     */
    protected function supportsException(\Exception $exception) {
        return $exception instanceof \Skautis\Exception;
    }

    /**
     * Obsluha vyjimky
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        if (!$this->supportsException($exception)) {
            return;
        }

        $response = new RedirectResponse("skautis/error");
        $event->setResponse($response);
    }

}