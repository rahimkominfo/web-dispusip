<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation" class="inline-flex items-center -space-x-px rounded border border-outline-variant bg-surface-container-lowest shadow-sm">
    <?php if ($pager->hasPrevious()) : ?>
        <a href="<?= $pager->getFirst() ?>" aria-label="First" class="px-4 py-2 text-sm font-medium text-on-surface-variant hover:bg-surface-container hover:text-primary transition-colors border-r border-outline-variant">
            Pertama
        </a>
    <?php endif ?>

    <?php foreach ($pager->links() as $link) : ?>
        <a href="<?= $link['uri'] ?>" class="px-4 py-2 text-sm <?= $link['active'] ? 'font-bold bg-primary text-on-primary' : 'font-medium text-on-surface-variant hover:bg-surface-container hover:text-primary' ?> transition-colors border-r border-outline-variant">
            <?= $link['title'] ?>
        </a>
    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>
        <a href="<?= $pager->getLast() ?>" aria-label="Last" class="px-4 py-2 text-sm font-medium text-on-surface-variant hover:bg-surface-container hover:text-primary transition-colors">
            Terakhir
        </a>
    <?php endif ?>
</nav>
