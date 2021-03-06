# Table **<?=$table->getName()?>**

[TOC]
<?php if (! empty($table->getDescription())) { ?>
## Description
<?= $table->getDescription() ?>
<?php } ?>

## Columns

| Column | Type | Attributes | Flags | Comments
| --- | --- | --- | --- | ---
<?php
/** @var \SqlDocumentor\Table\Column $column */
foreach($table->getColumns() as $column) {
    $flags = implode(', ', array_map(function($flag) { return "`$flag`"; }, $column->getFlags()));
?>
| `<?=$column->getName()?>` | `<?=$column->getType()?>` | `<?=$column->isNullable() ? 'NULL' : 'NOT NULL'?>`<?=$column->isAutoIncrement()?', `Auto-Increment`':''?> | <?=$flags?> | <?=$column->getComment()?> |
<?php } ?>

## Create query

```sql
<?=$table->getCreateQuery()?>

```
