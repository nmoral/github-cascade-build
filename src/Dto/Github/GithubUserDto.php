<?php

namespace App\Dto\Github;

class GithubUserDto
{
    private function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $accessToken,
        public readonly string $company,
        public readonly string $avatarUrl,
        public readonly string $profileUrl,
        public readonly string $login,
        public readonly ?string $email,
    )
    {
    }

    public static function create(array $data, string $accessToken): self
    {
        return new self(
            $data['id'],
            $data['name'],
            $accessToken,
            $data['company'],
            $data['avatar_url'],
            $data['html_url'],
            $data['login'],
            $data['email'],
        );
    }


}
