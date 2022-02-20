<?php

declare(strict_types=1);

namespace DeFixIT\Anonlytics\EventListener;

use DeFixIT\Anonlytics\Service\TrackService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestSubscriber implements EventSubscriberInterface
{
    private TrackService $trackService;

    public function __construct(
        TrackService $trackService
    ) {
        $this->trackService = $trackService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest'
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
       $this->trackService->sendRequestData($event->getRequest()->server);
    }
}