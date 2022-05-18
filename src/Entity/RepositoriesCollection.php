<?php

namespace App\Entity;

class RepositoriesCollection implements \Iterator
{
    private int $index = 0;

    private array $items = [];

    private array $knownRepository = [];

    private int $length = 0;

    public function add(Repository $repository)
    {
        if (isset($this->knownRepository[spl_object_id($repository)])) {
            return;
        }
        $this->knownRepository[spl_object_id($repository)] = $this->length;
        $this->items[] = $repository;
        ++$this->length;
    }

    public function current(): Repository
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
