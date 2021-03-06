<?php

namespace SqlDocumentor\Model;

/**
 * Class Column
 * @package SqlDocumentor\Model
 */
class Column
{
    /** @var string */
    protected $name = '';

    /** @var string */
    protected $type = '';

    /** @var bool  */
    protected $nullable = true;

    /** @var bool  */
    protected $autoIncrement = false;

    /** @var string */
    protected $comment = '';

    /** @var array */
    protected $flags = [];

    /**
     * Column constructor.
     * @param string $columnName
     */
    public function __construct(string $columnName)
    {
        $this->setName($columnName);
    }

    /**
     * @param string $name
     * @return Column
     */
    public function setName(string $name): Column
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Column
     */
    public function setType(string $type): Column
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNullable(): bool
    {
        return $this->nullable;
    }

    /**
     * @param bool $nullable
     * @return Column
     */
    public function setNullable(bool $nullable): Column
    {
        $this->nullable = $nullable;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoIncrement(): bool
    {
        return $this->autoIncrement;
    }

    /**
     * @param bool $autoIncrement
     * @return Column
     */
    public function setAutoIncrement(bool $autoIncrement): Column
    {
        $this->autoIncrement = $autoIncrement;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return Column
     */
    public function setComment(string $comment): Column
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return array
     */
    public function getFlags(): array
    {
        return array_keys($this->flags);
    }

    /**
     * @param string $flag
     * @return Column
     */
    public function addFlag(string $flag): Column
    {
        $this->flags[$flag] = true;
        return $this;
    }

    /**
     * @param string $flag
     * @return Column
     */
    public function delFlag(string $flag): Column
    {
        unset($this->flags[$flag]);
        return $this;
    }

    /**
     * @param string $flag
     * @return bool
     */
    public function hasFlag(string $flag): bool
    {
        return isset($this->flags[$flag]);
    }
}
