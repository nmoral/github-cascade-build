<?php

namespace App\Entity;

use App\Dto\Github\GithubUserDto;
use App\DoctrineRepositories\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, BaseEntity
{
    const ROLE_USER_OWNER = 'ROLE_USER_OWNER';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public int $id;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $password;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Repository::class)]
    private Collection $repositories;

    public function __construct(
        #[ORM\ManyToOne(targetEntity: Account::class, cascade: ['persist'], inversedBy: 'users')]
        private readonly Account $account,

        #[ORM\Column(type: 'string', length: 100, unique: true, nullable: true)]
        public ?string $email,

        #[ORM\Column(type: 'string', length: 50)]
        public string $name,

        #[Column(type: 'string', length: 75, nullable: false)]
        public string $accessToken,

        #[Column(type: 'string', length: 255, nullable: false)]
        public string $avatarUrl,

        #[Column(type: 'string', length: 255, nullable: false)]
        public string $publicProfile,

        #[Column(type: 'string', length: 100, nullable: false)]
        public string $company,

        #[ORM\Column(type: 'json')]
        public array $roles = [],
    ) {
    }

    public static function createFromGithub(
        GithubUserDto $githubAccount,
        Account $account,
        array $roles = [
            self::ROLE_USER_OWNER,
        ]
    ): User {
        return new self(
            $account,
            $githubAccount->email,
            $githubAccount->name,
            $githubAccount->accessToken,
            $githubAccount->avatarUrl,
            $githubAccount->profileUrl,
            $githubAccount->company,
            $roles

        );
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function shouldBePersisted(): bool
    {
        return null === $this->id;
    }

    public function atOrganization(): string
    {
        return $this->account->login;
    }
}
