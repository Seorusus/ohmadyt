<?php

namespace Drupal\ohmatdyt_domain\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Session\AccountInterface;

  class OhmatdytDomainSubscriber implements EventSubscriberInterface {
  private $currentUser;

  public function __construct(AccountInterface $currentUser) {
    $this->currentUser = $currentUser;
  }

  public static function getSubscribedEvents(): array {
    $events[KernelEvents::REQUEST][] = ['onRequest', 0];
    return $events;
  }

  public function onRequest(RequestEvent $event) {
    if ($event->getRequest()->getPathInfo() === '/' && $this->currentUser->isAnonymous()) {
      $domainNegotiator = \Drupal::service('domain.negotiator');
      $activeDomain = $domainNegotiator->getActiveDomain();

      switch ($activeDomain->id()) {
        default:
        case 'ohmatdyt':
          $event->setResponse(new RedirectResponse('/user/login'));
          break;

        case 'platforma':
          $event->setResponse(new RedirectResponse('/home'));
          break;
      }
    }
  }

}
