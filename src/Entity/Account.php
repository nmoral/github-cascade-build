<?php

namespace App\Entity;

use App\Dto\Github\GithubUserDto;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;

#[Entity]
class Account implements BaseEntity
{
    #[OneToMany(mappedBy: 'account', targetEntity: User::class)]
    private Collection $users;

    #[Column(type: 'integer', nullable: false)]
    #[Id]
    #[GeneratedValue]
    private ?int $id = null;

    public function __construct(
        #[Column(type: 'integer', nullable: false)]
        public int $externalId,

        #[Column(type: 'string', length: 100, nullable: false)]
        public string $name,

        #[Column(type: 'string', length: 50, nullable: false)]
        public string $login
    ) {
        $this->users = new ArrayCollection();
    }

    public static function createFromGithub(GithubUserDto $dto): self
    {
        return new self(
            $dto->id,
            $dto->name,
            $dto->login
        );
    }

    public function shouldBePersisted(): bool
    {
        return null === $this->id;
    }
}
