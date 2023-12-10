<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Test\Unit\Domain\Code;

use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Authentication\Domain\Code\Code;
use Project\Domains\Client\Authentication\Test\Unit\Application\CodeFactory;
use DateTimeImmutable;
use Project\Domains\Client\Authentication\Test\Unit\Application\MemberFactory;
use Project\Shared\Domain\Aggregate\AggregateRoot;

/**
 * @group client-auth-domain
 * @group client-auth-domain-code
 */
class CodeTest extends TestCase
{
    public function testFromPrimitives(): void
    {
        $code = Code::fromPrimitives(CodeFactory::CODE, $expiredAt = new DateTimeImmutable('+ 1 hours'));

        $this->assertNotNull($code);
        $this->assertNotInstanceOf(AggregateRoot::class, $code);
        $this->assertInstanceOf(Code::class, $code);

        $this->assertIsInt($code->getValue());
        $this->assertNotNull($code->getValue());
        $this->assertSame(CodeFactory::CODE, $code->getValue());

        $this->assertNotNull($code->getExpiredAt());
        $this->assertInstanceOf(DateTimeImmutable::class, $code->getExpiredAt());
        $this->assertSame($expiredAt, $code->getExpiredAt());
    }

    public function testCodeSetAuthor(): void
    {
        $code = CodeFactory::make();

        $this->assertNull($code->getAuthor());

        $code->setAuthor(
            MemberFactory::make(
                $uuid = 'd846d37d-e773-4282-a568-bbe838d18c56',
                $email = 'code@gmail.com',
            )
        );

        $this->assertNotNull($code->getAuthor());
        $this->assertSame($uuid, $code->getAuthor()->getUuid());
        $this->assertSame($email, $code->getAuthor()->getEmail());
    }

    public function testCodeSetValue(): void
    {
        $code = CodeFactory::make();

        $this->assertNotNull($code->getValue());
        $this->assertSame(CodeFactory::CODE, $code->getValue());

        $code->setValue($value = 440044);

        $this->assertNotNull($code->getValue());
        $this->assertSame($value, $code->getValue());
    }

    public function testCodeExpiredAt(): void
    {
        $code = CodeFactory::make();

        $this->assertNotNull($code->getExpiredAt());
        $this->assertInstanceOf(DateTimeImmutable::class, $code->getExpiredAt());
        // $this->assertSame(new DateTimeImmutable('+ 1 hours'), $code->getExpiredAt());

        $code->setExpiredAt($expiredAt = new DateTimeImmutable('+ 2 hours'));

        $this->assertNotNull($code->getExpiredAt());
        $this->assertSame($expiredAt, $code->getExpiredAt());
        $this->assertSame($expiredAt->getTimestamp(), $code->getExpiredAt()->getTimestamp());
    }
}
