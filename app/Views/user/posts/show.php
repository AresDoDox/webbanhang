<?php
$post = isset($post) ? $post : [
    'title' => '',
    'content' => '',
];
?>

<?php require '../app/Views/layouts/header.php'; ?>

<div class="mb-6">

    <h1 class="text-3xl font-bold">
        <?= htmlspecialchars(
            $post['title']
        ) ?>
    </h1>

    <p> Content:
        <?= nl2br(
            htmlspecialchars(
                $post['content']
            )
        ) ?>
    </p>
</div>

<?php require '../app/Views/layouts/footer.php'; ?>