<?php

if (isset($_POST['dbname'])) {
    extract($_POST);
    $save = <<<DATA
<?php

\$host     = '$host';
\$port     = $port;
\$dbname   = '$dbname';
\$user     = '$user';
\$password = '$pword';

DATA;
    file_put_contents('config.php', $save);
    $db  = pg_connect("host=$host port=$port user=$user password=$pword");
    $sql = "SELECT datname FROM pg_database";
    $result = pg_query($db, $sql);
    $isdb = false;
    foreach(pg_fetch_all_columns($result) as $base) {
        if ($dbname == $base)
            $isdb = true;
    }
    if ($isdb == false) {
        $sql = "CREATE DATABASE $dbname ENCODING 'UTF8'";
        pg_query($db, $sql);
        if (pg_last_error($db))
            exit(pg_last_error($db));
    }
    echo 'Success, database "<b>'.$dbname.'</b>" is created.<br>';
    echo '<b>config.php</b> was written';
    exit();
}
?>
Create a PostgreSQL Database<br>
and save values in config.php

<br><br>
<form method="post">
<table>
    <tr><td>HOST</td>
        <td><input type="text" name="host" value="localhost"></td></tr>
    <tr><td>PORT</td>
        <td><input type="text" name="port" value="5432"></td></tr>
    <tr><td>USERNAME</td>
        <td><input type="text" name="user" value="postgres"></td></tr>
    <tr><td>PASSWORD</td>
        <td><input type="text" name="pword"></td></tr>
    <tr><td>&nbsp;</td><td></td></tr>
    <tr><td>DATABASE<br>
        Can be existing<br>
        or will be created</td>
        <td valign="top"><input type="text" name="dbname"></td></tr>
    <tr><td>&nbsp;</td><td></td></tr>
    <tr><td></td>
        <td><input type="submit"></td></tr>
</table>
</form>
