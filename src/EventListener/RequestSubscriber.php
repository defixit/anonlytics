<?php

declare(strict_types=1);

namespace DeFixIT\AnonlyticsBundle\EventListener;

use DeFixIT\Anonlytics\Tracker;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestSubscriber implements EventSubscriberInterface
{
    private ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest'
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $tracker = new Tracker(
            $event->getRequest()->server->all(),
            $this->parameterBag->get('anonlytics.client_token'),
            $this->parameterBag->get('anonlytics.site_token')
        );

       $tracker->sendRequestData();
    }
}