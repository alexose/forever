<h1>Your sets</h1>

<?php 
echo form_open("set/add", 'name="add_set"');
echo form_fieldset('Add a set');
echo form_input('title');
echo form_textarea('description');
echo form_submit('add', 'Add Set');
echo form_fieldset_close();
echo form_close();
?>

<ul class="set-list">
<?php foreach ($this->data['sets'] as $set): ?>
    <li>
        <h2><?= $set['title'] ?></h2>
        <p class="description"><?= $set['description'] ?></p>
    </li>
<?php endforeach; ?>
</ul>
