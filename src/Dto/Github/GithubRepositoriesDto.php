<?php

namespace App\Dto\Github;

class GithubRepositoriesDto
{
    private function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $fullName,
        public readonly string $url
    ) {
    }

    public static function create(mixed $item): GithubRepositoriesDto
    {
        return new self(
            $item['id'],
            $item['name'],
            $item['full_name'],
            $item['html_url']
        );
    }
}
