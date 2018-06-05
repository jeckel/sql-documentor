# Table **<?=$table->getName()?>**

[TOC]
<?php if (! empty($table->getDescription())) { ?>
## Description
<?= $table->getDescription() ?>
<?php } ?>

## Columns

| Column | Type | Attributes | Comments
| --- | --- | --- | ---
<?php foreach($table->getColumns() as $column) { ?>
| `<?=$column->getName()?>` | `<?=$column->getType()?>` | `<?=$column->isNullable() ? 'NULL' : 'NOT NULL'?>`<?=$column->isAutoIncrement()?', `Auto-Increment`':''?> | <?=$column->getComment()?> |
<?php } ?>

## Create query

```sql
<?=$table->getCreateQuery()?>
```
