<?php

require './extended-vigenere-cipher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  if ($_FILES['plain']['error'] === UPLOAD_ERR_OK) {
    $tmp = explode('.', $_FILES['plain']['name']);
    $ext = end($tmp);
    $key = $_POST['key'] ?? '';
    $plainText = file_get_contents($_FILES['plain']['tmp_name']);
    $cipherText = ExtendedVigenere::encrypt($plainText, $key);

    file_put_contents(__DIR__ . "/../uploads/encrypt.$ext", $cipherText);
  }
}

?>

<?php include __DIR__ . '/../components/_header.php' ?>

<div class="card position-absolute top-50 start-50 translate-middle">
  <div class="card-body">
    <a href="/index.php" class="btn btn-secondary mb-3">Back to home</a>
    <h5 class="card-title fs-3">Encrypt Extended Vigenere Cipher with File</h5>
    <hr>
    <form method="post" enctype="multipart/form-data">
      <div class="my-3">
        <label for="plain" class="form-label"><strong>Plain file:</strong></label>
        <input type="file" name="plain" id="plain" class="form-control">
      </div>
      <div class="my-3">
        <label for="key" class="form-label"><strong>Key:</strong></label>
        <input type="text" id="key" name="key" class="form-control">
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Encrypt</button>
    </form>
    <hr>
    <?php if (isset($_FILES['plain']['tmp_name'])) : ?>
      <p>
        <a href="/uploads/encrypt.<?= $ext ?>" download>Download file</a>
      </p>
    <?php else : ?>
      <p>
        <strong>Please upload a file</strong>
      </p>
    <?php endif ?>
  </div>
</div>