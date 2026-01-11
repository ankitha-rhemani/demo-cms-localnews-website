<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $article = $_POST["article"] ?? null;

    if (!$article) {
        echo json_encode(["status" => "error", "message" => "Missing required fields"]);
        exit;
    }

    $file = "../data/content.json";
    $articles = [];

    if (file_exists($file)) {
        $articles = json_decode(file_get_contents($file), true) ?? [];
    }

    $newArticle = json_decode($article, true);
    if (!$newArticle) {
        echo json_encode(['status'=>'error','message'=>'Invalid article data']);
        exit;
    }

    $articles[] = $newArticle;

    if (file_put_contents($file, json_encode($articles, JSON_PRETTY_PRINT))) {
        echo json_encode(['status'=>'success']);
    } else {
        echo json_encode(['status'=>'error','message'=>'Failed to save article']);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>
