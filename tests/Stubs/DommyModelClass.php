<?php

namespace Tests\Stubs;

use Bow\Csv\Csv;
use Bow\Database\Barry\Model;

class DommyModelClass extends Model
{
    use Csv;

    /**
     * Fake persisted rows for assertions.
     *
     * @var array
     */
    public array $saved = [];

    /**
     * Dataset to be returned by query-like calls.
     *
     * @var array
     */
    private array $dataset = [];

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function setDataset(array $rows): void
    {
        $this->dataset = $rows;
    }

    public function select($columns = ['*'])
    {
        return $this;
    }

    public function get()
    {
        $rows = $this->dataset;

        if (empty($rows)) {
            $rows = [$this->attributes];
        }

        return collect(array_map(fn ($row) => new self($row), $rows));
    }

    public function count()
    {
        if (!empty($this->dataset)) {
            return count($this->dataset);
        }

        return empty($this->attributes) ? 0 : 1;
    }

    public function first(): object|array|null
    {
        $row = $this->dataset[0] ?? $this->attributes;

        return new self($row);
    }

    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function save(): void
    {
        $this->saved[] = $this->attributes;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}
