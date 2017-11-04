<?php
$db = new PDO('sqlite:' . realpath(__DIR__) . '/selling_website.db');
$fh = fopen(__DIR__ . '/schema.sql', 'r');
for($i=1;$i<20;$i++) {
while ($line = fread($fh, 4096)) {
    $db->exec($line);
}
fseek($fh, 0);
}
fclose($fh);