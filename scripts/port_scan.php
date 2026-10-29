<?php
foreach ([3306, 3307, 3308, 3309] as $port) {
    try {
        $pdo = new PDO("mysql:host=127.0.0.1;port=$port", "root", "");
        echo "Port $port: Connected. ";
        $dbs = $pdo->query("SHOW DATABASES")->fetchAll(PDO::FETCH_COLUMN);
        if (in_array('dbstereo', $dbs)) {
             $pdo->query("USE dbstereo");
             try {
                 $count = $pdo->query("SELECT COUNT(*) FROM news")->fetchColumn();
                 echo "dbstereo found! News rows: $count\n";
             } catch (Exception $e) { echo "dbstereo found, but no news table.\n"; }
        } else {
             echo "dbstereo NOT found.\n";
        }
    } catch (Exception $e) {
        // Port closed
    }
}
