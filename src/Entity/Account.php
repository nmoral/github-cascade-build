<?php

namespace App\Entity;

use App\Dto\Github\GithubUserDto;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Account
{
    public function __construct(
        #[Column(type: 'integer', nullable: false)]
        public readonly int $externalId,

        #[Column(type: 'string', length: 100, nullable: false)]
        public readonly string $name,

        #[Column(type: 'string', length: 75, nullable: false)]
        public readonly string $accessToken,

        #[Column(type: 'string', length: 100, nullable: false)]
        public readonly string $company,

        #[Column(type: 'string', length: 255, nullable: false)]
        public readonly string $avatarUrl,

        #[Column(type: 'string', length: 255, nullable: false)]
        public readonly string $publicProfile,

        #[Column(type: 'integer', nullable: false)]
        #[Id]
        #[GeneratedValue]
        public ?int $id = null,
    ) {
    }

    public static function createFromGithub(GithubUserDto $dto): self
    {
        return new self(
            $dto->id,
            $dto->name,
            $dto->accessToken,
            $dto->company,
            $dto->avatarUrl,
            $dto->profileUrl
        );
    }
}
