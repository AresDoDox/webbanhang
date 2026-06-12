<?php

use App\Helpers\Flash;

?>

<?php if ($message = Flash::get('success')): ?>

    <div class="mb-4 rounded bg-green-100 p-4 text-green-700">
        <?= htmlspecialchars($message) ?>
    </div>

<?php endif; ?>

<?php if ($message = Flash::get('error')): ?>

    <div class="mb-4 rounded bg-red-100 p-4 text-red-700">
        <?= htmlspecialchars($message) ?>
    </div>

<?php endif; ?>