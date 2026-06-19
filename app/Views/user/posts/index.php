<?php require '../app/Views/layouts/header.php'; ?>

<div class="flex justify-between mb-6">

    <h1 class="text-3xl font-bold">
        Posts
    </h1>

    <a href="<?= BASE_PATH ?>/posts/create" class="bg-indigo-600 text-white px-4 py-2 rounded">
        Add Post
    </a>

</div>

<table class="w-full bg-white shadow">

    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($posts ?? [] as $post): ?>

        <tr>

            <td>
                <?= $post['id'] ?>
            </td>

            <td>
                <?= htmlspecialchars($post['title']) ?>
            </td>

            <td>
                <?= htmlspecialchars($post['content']) ?>
            </td>

            <td>
                <a href="<?= BASE_PATH ?>/posts/show?id=<?= $post['id'] ?>" class="text-blue-500">
                    View
                </a>
                <a href="<?= BASE_PATH ?>/posts/edit?id=<?= $post['id'] ?>" class="text-blue-500">
                    Edit
                </a>
                <a href="<?= BASE_PATH ?>/posts/delete?id=<?= $post['id'] ?>" class="text-red-500">
                    Delete
                </a>
            </td>
        </tr>

        <?php endforeach; ?>
    </tbody>
</table>


<?php require '../app/Views/layouts/footer.php'; ?>