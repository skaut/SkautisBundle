<?php

namespace SkautisBundle\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class SkautisExceptionListener
{

    protected function supportsException(\Exception $exception) {
        return $exception instanceof \Skautis\Exception;
    }

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