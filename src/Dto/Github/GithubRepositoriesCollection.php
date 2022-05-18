<?php

namespace App\Dto\Github;

use JetBrains\PhpStorm\Internal\TentativeType;

class GithubRepositoriesCollection implements \Iterator
{
    private int $index = 0;

    /**
     * @var GithubRepositoriesDto[]
     */
    private array $items = [];

    private function __construct(GithubRepositoriesDto ...$items)
    {
        $this->items = $items;
    }

    public static function create(array $data): GithubRepositoriesCollection
    {
        $items = [];
        foreach ($data as $item) {
            $items[] = GithubRepositoriesDto::create($item);
        }

        return new self(...$items);
    }

    public function current(): GithubRepositoriesDto
    {
        return $this->items[$this->key()];
    }

    public function next(): void
    {
        ++$this->index;
    }

    public function key(): int
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return isset($this->items[$this->key()]);
    }

    public function rewind(): void
    {
        $this->index = 0;
    }
}
