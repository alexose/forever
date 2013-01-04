<h1>Your photos</h1>

<ul class="photo-list">
<?php foreach ($this->data['photos'] as $photo): ?>
    <li>
        <h2><?= $photo['title'] ?></h2>
        <img src="<?= $photo['url'] ?>" />
    </li>
<?php endforeach; ?>
</ul>
