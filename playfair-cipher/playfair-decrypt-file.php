<?php

require './vigenere-cipher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  if ($_FILES['cipher']['error'] === UPLOAD_ERR_OK) {
    $fileLocation = $_FILES['cipher']['tmp_name'];
    $cipherText = file_get_contents($fileLocation);
    $key = $_POST['key'] ?? '';
    $plainText = Vigenere::decrypt($cipherText, $key);

    $filename = 'decrypt-' . uniqid() . '.txt';
    file_put_contents(__DIR__ . '/../uploads/' . $filename, $plainText);
  }
}

?>

<?php include __DIR__ . '/../components/_header.php' ?>

<div class="card position-absolute top-50 start-50 translate-middle">
  <div class="card-body">
    <a href="/index.php" class="btn btn-secondary mb-3">Back to home</a>
    <h5 class="card-title fs-3">Decrypt Vigenere Cipher with Text File</h5>
    <hr>
    <form method="post" enctype="multipart/form-data">
      <div class="my-3">
        <label for="cipher" class="form-label"><strong>Cipher text file:</strong></label>
        <input type="file" name="cipher" id="cipher" accept=".txt" class="form-control" required>
      </div>
      <div class="my-3">
        <label for="key" class="form-label"><strong>Key (a-z):</strong></label>
        <input type="text" id="key" name="key" class="form-control" required pattern="[a-zA-Z]*">
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Decrypt</button>
    </form>
    <hr>
    <?php if (isset($plainText)) : ?>
      <p>
        <strong>Output:</strong> <?= $plainText ?>
      </p>
      <p>
        <a href="/uploads/<?= $filename ?>" download>Download decrypted text file</a>
      </p>
      <p>
        <strong>Output (base64):</strong> <?= base64_encode($plainText) ?>
      </p>
    <?php else : ?>
      <p>
        <strong>Please input cipher text file and key</strong>
      </p>
    <?php endif ?>
  </div>
</div>

<?php include __DIR__ . '/../components/_footer.php'; ?>