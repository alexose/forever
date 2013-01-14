<h1>Your photos</h1>

<?php 
echo form_open_multipart("photo/add", 'name="add_photo"');
echo form_fieldset('Add a photo');
echo form_input('title');
echo form_upload('userfile');
echo form_submit('upload', 'Upload');
echo form_fieldset_close();
echo form_close();
?>

<ul class="photo-list">
<?php foreach ($this->data['photos'] as $photo): ?>
    <li>
        <h2><?= $photo['title'] ?></h2>
        <img src="<?= "http://s3.amazonaws.com/" . $bucketName . '/' . $photo['uri'] ?>" />
    </li>
<?php endforeach; ?>
</ul>
