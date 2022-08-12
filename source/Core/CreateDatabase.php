<?php

namespace Source\Core;

use Erykai\Database\TraitDatabase;

class CreateDatabase
{
    use TraitDatabase;
    private string $table;
    private array $columns;
    private array $types;
    private array $null;
    private array $default;
    private array $extra;

    public function table(string $name): void
    {
        $this->setTable($name);
    }

    public function column(string $name): static
    {
        $this->setColumns($name);
        return $this;
    }

    public function type(string $name): static
    {
        $this->setTypes($name);
        return $this;
    }

    public function null(bool $true = true): static
    {
        $this->setNull($true);
        return $this;
    }
    public function default(bool|string $default = false): static
    {
        $this->setDefault($default);
        return $this;
    }
    public function extra(bool|string $extra = false): static
    {
        $this->setExtra($extra);
        return $this;
    }

    public function save(): void
    {
        $query = "(";
        $default = null;
        foreach ($this->getColumns() as $key => $column) {
            if(!$this->getNull()[$key]){
                $null = 'NOT NULL';
            }
            if($this->getDefault()[$key]){
                $null = null;
                $default = 'DEFAULT ' . $this->getDefault()[$key];
            }
            $query .= "`$column` {$this->getTypes()[$key]} $default $null,";
        }
        $query .= "`created_at` timestamp NOT NULL DEFAULT current_timestamp(),`updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp())";
        $query .= "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $data = "CREATE TABLE {$this->getTable()} $query";
        $this->conn()->query($data);
    }



    /**
     * @return string
     */
    protected function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    protected function setTable(string $table): void
    {
        $this->table = $table;
    }

    /**
     * @return array
     */
    protected function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param string $column
     */
    protected function setColumns(string $column): void
    {
        $this->columns[] = $column;
    }

    /**
     * @return array
     */
    protected function getTypes(): array
    {
        return $this->types;
    }

    /**
     * @param string $type
     */
    protected function setTypes(string $type): void
    {
        $this->types[] = $type;
    }

    /**
     * @return array
     */
    protected function getNull(): array
    {
        return $this->null;
    }

    /**
     * @param bool $null
     */
    protected function setNull(bool $null): void
    {
        $this->null[] = $null;
    }

    /**
     * @return array
     */
    protected function getDefault(): array
    {
        return $this->default;
    }

    /**
     * @param bool|string $default
     */
    protected function setDefault(bool|string $default): void
    {
        $this->default[] = $default;
    }

    /**
     * @return array
     */
    protected function getExtra(): array
    {
        return $this->extra;
    }

    /**
     * @param bool|string $extra
     */
    protected function setExtra(bool|string $extra): void
    {
        $this->extra[] = $extra;
    }
}