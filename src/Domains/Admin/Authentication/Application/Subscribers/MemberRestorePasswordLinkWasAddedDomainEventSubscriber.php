<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Subscribers;

use Project\Domains\Admin\Authentication\Domain\Member\Events\MemberRestorePasswordLinkWasAddedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class MemberRestorePasswordLinkWasAddedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly MailerInterface $mailer,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [
            MemberRestorePasswordLinkWasAddedDomainEvent::class,
        ];
    }

    public function __invoke(MemberRestorePasswordLinkWasAddedDomainEvent $event): void
    {
        $view = view('mail.admin.auth.restore_password_link', [
            'restoreLink' => $this->makeRestoreLink($event),
        ])->render();

        $message = (new Email())
                ->from(getenv('MAIL_FROM_ADDRESS'))
                ->to($event->email)
                ->subject('Time for Symfony Mailer!')
                ->text('Sending emails is fun again!')
                ->html($view);
            
        $this->mailer->send($message);
    }

    private function makeRestoreLink(MemberRestorePasswordLinkWasAddedDomainEvent $event): string
    {
        $url = config('admin_dashboard.admin_url') . config('admin_dashboard.page_routers.reset_password');

        return $url . '?' . http_build_query(['token' => $event->token]);
    }
}
