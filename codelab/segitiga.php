<?php
echo "Segitiga\n\n";
$baris = 5;
for ($i = 1; $i <= $baris; $i++) {
    echo str_repeat(" ", $baris - $i) . str_repeat("*", 2 * $i - 1) . "\n";
}

echo "\n";
echo "Segita terbalik\n\n";
$baris = 5;
for ($i = $baris; $i >= 1; $i--) {
    echo str_repeat(" ", $baris - $i) . str_repeat("*", 2 * $i - 1) . "\n";
}