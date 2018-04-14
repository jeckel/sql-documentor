<?php

namespace SqlDocumentor\Table;

/**
 * Class Column
 * @package SqlDocumentor\Table
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
}
