<?php
$product = isset($product) ? $product : [
    'name' => '',
    'image' => '',
    'description' => '',
    'price' => ''
];
?>

<?php require '../app/Views/layouts/header.php'; ?>

<div class="mb-6">

    <h1 class="text-3xl font-bold">
        <?= htmlspecialchars(
            $product['name']
        ) ?>
    </h1>

    <p> Description:
        <?= nl2br(
            htmlspecialchars(
                $product['description']
            )
        ) ?>
    </p>
</div>

<figure class="max-w-lg">
    <img class="h-auto max-w-full rounded-base" src="/webbanhang/storage/uploads/<?= $product['image'] ?>"
        alt="image description">
    <figcaption class="mt-2 text-sm text-center text-body">Price: <?= $product['price'] ?></figcaption>
</figure>

<?php require '../app/Views/layouts/footer.php'; ?>