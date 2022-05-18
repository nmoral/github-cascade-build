<?php

namespace App\Entity;

use App\Dto\Github\GithubRepositoriesDto;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

#[Entity]
class Repository implements BaseEntity
{
    #[OneToMany(mappedBy: 'repository', targetEntity: Workflow::class)]
    private Collection $workflows;

    public static function createFromGithub(GithubRepositoriesDto $repositoriesDto, User $user, ?int $id = null): Repository
    {
        return new self(
            $repositoriesDto->id,
            $repositoriesDto->name,
            $repositoriesDto->fullName,
            $repositoriesDto->url,
            $user,
            $id
        );
    }

    private function __construct(
        #[Column(type: 'integer')]
        public int $externalId,
        #[Column(type: 'string', length: 100)]
        public string $name,
        #[Column(type: 'string', length: 100)]
        public string $fullName,
        #[Column(type: 'string', length: 255)]
        public string $url,
        #[ManyToOne(targetEntity: User::class, cascade: ['persist'], inversedBy: 'repositories')]
        public readonly User $user,
        #[Column(type: 'integer')]
        #[GeneratedValue]
        #[Id]
        public ?int $id = null
    ) {
    }

    public function shouldBePersisted(): bool
    {
        return null === $this->id;
    }
}
