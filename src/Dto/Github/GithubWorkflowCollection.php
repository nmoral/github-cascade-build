<?php

namespace App\Dto\Github;

class GithubWorkflowCollection implements \Iterator
{
    private int $index = 0;

    /**
     * @var GithubWorkflowDto[]
     */
    private array $items = [];

    private function __construct(GithubWorkflowDto ...$items)
    {
        $this->items = $items;
    }

    public static function create(array $data): GithubWorkflowCollection
    {
        $items = [];

        foreach ($data['workflows'] as $item) {
            $items[] = GithubWorkflowDto::create($item);
        }

        return new self(...$items);
    }

    public function current(): GithubWorkflowDto
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
