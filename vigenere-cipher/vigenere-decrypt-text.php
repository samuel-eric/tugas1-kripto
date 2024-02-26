<?php

require './vigenere-cipher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $cipherText = $_POST['cipher'] ?? '';
  $key = $_POST['key'] ?? '';
  $plainText = Vigenere::decrypt($cipherText, $key);

  file_put_contents(__DIR__ . '/../uploads/decrypt.txt', $plainText);
}

?>

<?php include __DIR__ . '/../components/_header.php' ?>

<div class="card position-absolute top-50 start-50 translate-middle">
  <div class="card-body">
    <a href="/index.php" class="btn btn-secondary mb-3">Back to home</a>
    <h5 class="card-title fs-3">Decrypt Vigenere Cipher</h5>
    <hr>
    <form method="post">
      <div class="my-3">
        <label for="cipher"><strong>Cipher text:</strong></label>
        <input type="text" id="cipher" name="cipher" value="<?= htmlspecialchars($_POST['cipher'] ?? '') ?>">
      </div>
      <div class="my-3">
        <label for="key"><strong>Key:</strong></label>
        <input type="text" id="key" name="key" value="<?= htmlspecialchars($_POST['key'] ?? '') ?>">
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Decrypt</button>
    </form>
    <hr>
    <?php if (isset($plainText)) : ?>
      <p>
        <strong><?= $plainText ?></strong>
      </p>
      <p>
        <a href="/uploads/decrypt.txt" download>Download decrypted text file</a>
      </p>
    <?php else : ?>
      <p>
        <strong>Please input cipher text and key</strong>
      </p>
    <?php endif ?>
  </div>
</div>

<?php include __DIR__ . '/../components/_footer.php'; ?>