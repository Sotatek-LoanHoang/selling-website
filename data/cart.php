<?php
$db = new PDO('sqlite:' . realpath(__DIR__) . '/selling_website.db');
$fh = fopen(__DIR__ . '/cart.sql', 'r');
while ($line = fread($fh, 4096)) {
    $db->exec($line);
}
fclose($fh);
?>
