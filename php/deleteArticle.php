<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST['id'] ?? null;
    $username = $_POST['username'] ?? null;

    if (!$id || !$username) {
        echo json_encode(['status' => 'error', 'message' => 'Missing fields']);
        exit;
    }

    $file = '../data/content.json';
    $articles = json_decode(file_get_contents($file), true) ?? [];

    $filtered = [];
    foreach ($articles as $article) {
        if (!($article['id'] == $id && $article['username'] === $username)) {
            $filtered[] = $article;
        }
    }

    if (count($filtered) < count($articles)) {
        file_put_contents($file, json_encode($filtered, JSON_PRETTY_PRINT));
        echo json_encode(['status' => 'success', 'message' => 'Article deleted']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Article not found']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
