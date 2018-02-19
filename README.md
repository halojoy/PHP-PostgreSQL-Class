### PHP-PostgreSQL-Class
PHP Class for easy work with PostgreSQL database<br>

For tryout:
1. run create_database.php
2. run create_table.php
3. run query.php

Query Examples:<br>

```php
require 'classPgSql.php';
$pg = new PgSql();

$sql = "SELECT * FROM books";
foreach($pg->getRows($sql) as $row) {
    echo $row->id.'."';
    echo $row->title.'" by ';
    echo $row->author.' (';
    echo $row->year.')';
    echo '<br>';
}
echo '<br>';

$sql = "SELECT * FROM books WHERE author='June Landers'";
$row = $pg->getRow($sql);
echo $row->id.'."';
echo $row->title.'" by ';
echo $row->author.' (';
echo $row->year.')';
echo '<br><br>';

$sql = "SELECT title FROM books WHERE author='George Hamilton'";
echo $pg->getCol($sql);
echo '<br><br>';

$sql = "SELECT author FROM books ORDER BY author";
foreach($pg->getColValues($sql) as $name) {
    echo $name;
    echo '<br>';
}
echo '<br>';

$pg->close();
```
