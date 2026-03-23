<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

#[AsEventListener(event: LoginSuccessEvent::class)]
class LoginSuccessListener
{
    public function __construct(
        private UrlGeneratorInterface $router
    ) {}

    // 👇 C'est ici que ça change ! On utilise __invoke
    public function __invoke(LoginSuccessEvent $event): void
    {
        $user = $event->getUser();

        if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            $response = new RedirectResponse($this->router->generate('app_chien_dashboard'));
        } else {
            $response = new RedirectResponse($this->router->generate('app_home'));
        }

        $event->setResponse($response);
    }
}