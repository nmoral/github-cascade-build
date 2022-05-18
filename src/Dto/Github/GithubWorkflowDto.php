<?php

namespace App\Dto\Github;

class GithubWorkflowDto
{
    private function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $url
    ) {
    }

    public static function create(array $item): GithubWorkflowDto
    {
        return new self(
            $item['id'],
            $item['name'],
            $item['html_url']
        );
    }
}
