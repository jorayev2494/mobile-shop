<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Commands\Confirm;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Cart\Domain\Cart\CartRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\AuthorUuid;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\OrderConfirmData;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
        private readonly AuthManagerInterface $authManager,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $cart = $this->cartRepository->findCartByAuthorUuid(AuthorUuid::fromValue($this->authManager->uuid()));

        $cart ?? throw new ModelNotFoundException();

        // if ($cart->getStatus()->isEquals(StatusEnum::CONFIRM)) {
        //     throw new DomainException('This cart already confirmed');
        // }

        $orderConfirmData = new OrderConfirmData(
            $command->cardUuid,
            $command->addressUuid,
            $command->currencyUuid,
            $command->email,
            $command->phone,
            $command->promoCode,
            $command->note
        );

        $cart->confirm($orderConfirmData);

        $this->cartRepository->save($cart);
        // dd($this->eventBus, $cart);
        $this->eventBus->publish(...$cart->pullDomainEvents());
    }
}
