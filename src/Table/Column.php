<?php

namespace SqlDocumentor\Table;

/**
 * Class Column
 * @package SqlDocumentor\Table
 */
class Column
{
    const FLAG_NULL = 'NULL';
    const FLAG_NOT_NULL = 'NOT NULL';
    const FLAG_AUTOINCREMENT = 'Auto-Increment';

    /** @var string */
    protected $name = '';

    /** @var string */
    protected $type = '';

    /** @var string */
    protected $comment = '';

    /** @var array */
    protected $flags = [];

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
        return $this->hasFlag(self::FLAG_NULL);
    }

    /**
     * @param bool $nullable
     * @return Column
     */
    public function setNullable(bool $nullable): Column
    {
        $nullable ? $this->addFlag(self::FLAG_NULL) : self::delFlag(self::FLAG_NULL);
        $nullable ? $this->delFlag(self::FLAG_NOT_NULL) : self::addFlag(self::FLAG_NOT_NULL);
        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoIncrement(): bool
    {
        return $this->hasFlag(self::FLAG_AUTOINCREMENT);
    }

    /**
     * @param bool $autoIncrement
     * @return Column
     */
    public function setAutoIncrement(bool $autoIncrement): Column
    {
        $autoIncrement ? $this->addFlag(self::FLAG_AUTOINCREMENT) : $this->delFlag(self::FLAG_AUTOINCREMENT);
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
