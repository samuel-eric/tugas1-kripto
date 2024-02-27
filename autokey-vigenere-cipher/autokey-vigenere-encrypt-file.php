<?php

require './autokey-vigenere-cipher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  if ($_FILES['plain']['error'] === UPLOAD_ERR_OK) {
    $fileLocation = $_FILES['plain']['tmp_name'];
    $plainText = file_get_contents($fileLocation);
    $key = $_POST['key'] ?? '';
    $cipherText = AutokeyVigenere::encrypt($plainText, $key);

    $filename = 'encrypt-' . uniqid() . '.txt';
    file_put_contents(__DIR__ . '/../uploads/' . $filename, $cipherText);
  }
}

?>

<?php include __DIR__ . '/../components/_header.php' ?>

<div class="card position-absolute top-50 start-50 translate-middle">
  <div class="card-body">
    <a href="/index.php" class="btn btn-secondary mb-3">Back to home</a>
    <h5 class="card-title fs-3">Encrypt Vigenere Cipher with Text File</h5>
    <hr>
    <form method="post" enctype="multipart/form-data">
      <div class="my-3">
        <label for="plain" class="form-label"><strong>Plain text file:</strong></label>
        <input type="file" name="plain" id="plain" accept=".txt" class="form-control">
      </div>
      <div class="my-3">
        <label for="key" class="form-label"><strong>Key:</strong></label>
        <input type="text" id="key" name="key" class="form-control">
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Encrypt</button>
    </form>
    <hr>
    <?php if (isset($cipherText)) : ?>
      <p>
        <strong><?= $cipherText ?></strong>
      </p>
      <p>
        <a href="/uploads/<?= $filename ?>" download>Download encrypted text file</a>
      </p>
    <?php else : ?>
      <p>
        <strong>Please input plain text file and key</strong>
      </p>
    <?php endif ?>
  </div>
</div>

<?php include __DIR__ . '/../components/_footer.php'; ?>