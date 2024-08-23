<?php

$pdo = new PDO(
    'mysql:host=' . $env['DATABASE_HOST'] . ';port=' . $env['DATABASE_PORT'] . ';dbname=' . $env['DATABASE_NAME'] . ';charset=utf8mb4',
    $env['DATABASE_USERNAME'],
    $env['DATABASE_PASSWORD']);
