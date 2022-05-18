<?php

namespace App\Entity;


class WorkFlowsCollection implements \Iterator, \JsonSerializable
{
    private int $index = 0;

    private array $items = [];

    private array $knownWorkflow = [];

    private int $length = 0;

    public function add(Workflow $repository)
    {
        if (isset($this->knownWorkflow[spl_object_id($repository)])) {
            return;
        }
        $this->knownWorkflow[spl_object_id($repository)] = $this->length;
        $this->items[] = $repository;
        ++$this->length;
    }

    public function current(): Workflow
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

    public function jsonSerialize(): array
    {
        return $this->items;
    }
}
