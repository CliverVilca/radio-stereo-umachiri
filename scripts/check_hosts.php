<?php
try {
    $p = new PDO('mysql:host=localhost;dbname=dbstereo', 'root', '');
    echo "Connected to localhost\n";
    $count = $p->query('SELECT COUNT(*) FROM users')->fetchColumn();
    echo "Users count (localhost): $count\n";
    
    $news = $p->query('SELECT COUNT(*) FROM news')->fetchColumn();
    echo "News count (localhost): $news\n";
} catch(PDOException $e) {
    echo "Localhost Error: " . $e->getMessage() . "\n";
}

try {
    $p = new PDO('mysql:host=127.0.0.1;dbname=dbstereo', 'root', '');
    echo "Connected to 127.0.0.1\n";
    $count = $p->query('SELECT COUNT(*) FROM users')->fetchColumn();
    echo "Users count (127.0.0.1): $count\n";
} catch(PDOException $e) {
    echo "127.0.0.1 Error: " . $e->getMessage() . "\n";
}
