<?php
$page = $_GET['page'] ?? 'home';

require_once __DIR__ . '/app/views/' . $page . '.php';

