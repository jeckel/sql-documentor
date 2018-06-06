# List of tables

<?php
$letters = [];
foreach (range('A', 'Z') as $letter) {
    $letters[] = "[$letter](#$letter)";
}
echo implode(' - ', $letters)
?>


<?php
ksort($tables);
$currentLetter = '';
foreach($tables as $tableName=>$table) {
    if ($tableName[0] != $currentLetter) {
        $currentLetter = $tableName[0];
        printf("## %s\n", strtoupper($currentLetter));
    }
    ?>
- [<?=$tableName?>](<?=$tableName?>.md) <?=(!empty($table->getDescription()))?"({$table->getDescription()})":''?>

<?php } ?>
