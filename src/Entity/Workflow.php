<?php

namespace App\Entity;

use App\Dto\Github\GithubWorkflowDto;
use App\Request\Repository\WorkflowRequest;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Internal\TentativeType;

#[Entity]
class Workflow implements BaseEntity, \JsonSerializable
{
    private function __construct(
        #[Column(type: 'integer')]
        public int $externalId,
        #[Column(type: 'string', length: 100)]
        public string $name,
        #[Column(type: 'string', length: 255)]
        public string $url,
        #[ManyToOne(targetEntity: User::class, cascade: ['persist'], inversedBy: 'repositories')]
        public readonly User $user,
        #[ManyToOne(targetEntity: Repository::class, cascade: ['persist'], inversedBy: 'workflows')]
        public readonly Repository $repository,
        #[Column(type: 'integer')]
        #[GeneratedValue]
        #[Id]
        public ?int $id = null
    ) {
    }

    public static function createFromGithub(
        GithubWorkflowDto $workflowDto,
        WorkflowRequest $request,
        ?int $id
    ): Workflow {
        return new self(
            $workflowDto->id,
            $workflowDto->name,
            $workflowDto->url,
            $request->getUser(),
            $request->getRepository(),
            $id
        );
    }

    public function shouldBePersisted(): bool
    {
        return null === $this->id;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'url'  => $this->url,
        ];
    }
}
