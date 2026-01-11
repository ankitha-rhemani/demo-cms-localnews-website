<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $id = $_POST['id'] ?? null;
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $username = trim($_POST['username'] ?? '');


    if (!$id || !$title || !$content || !$username) {
        echo json_encode(['status' => 'error', 'message' => 'Missing fields']);
        exit;
    }

 
    $file = '../data/content.json';
    $articles = json_decode(file_get_contents($file), true) ?? [];

    // Find and update the matching article
    $found = false;
    foreach ($articles as &$article) {
        if ($article['id'] == $id && $article['username'] === $username) {
            $article['title'] = $title;
            $article['content'] = $content;
            $found = true;
            break;
        }
    }

    if ($found) {
        file_put_contents($file, json_encode($articles, JSON_PRETTY_PRINT));
        echo json_encode(['status' => 'success', 'message' => 'Article updated']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Article not found']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
