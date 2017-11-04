<?php
$db = new PDO('sqlite:' . realpath(__DIR__) . '/selling_website_test.db');
$fh = fopen(__DIR__ . '/user.sql', 'r');
while ($line = fread($fh, 4096)) {
    $db->exec($line);
}
fclose($fh);
?>
