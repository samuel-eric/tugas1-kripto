<?php

require './playfair-cipher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $plainText = $_POST['plain'] ?? '';
  $key = $_POST['key'] ?? '';
  $cipherText = PlayfairCipher::encrypt($plainText, $key);

  $filename = 'encrypt-' . uniqid() . '.txt';
  file_put_contents(__DIR__ . '/../uploads/' . $filename, $cipherText);
}

?>

<?php include __DIR__ . '/../components/_header.php' ?>

<div class="card position-absolute top-50 start-50 translate-middle">
  <div class="card-body">
    <a href="/index.php" class="btn btn-secondary mb-3">Back to home</a>
    <h5 class="card-title fs-3">Encrypt Playfair Cipher</h5>
    <hr>
    <form method="post">
      <div class="my-3">
        <label for="plain" class="form-label"><strong>Plain text:</strong></label>
        <textarea id="plain" name="plain" class="form-control" required><?= htmlspecialchars($_POST['plain'] ?? '') ?></textarea>
      </div>
      <div class="my-3">
        <label for="key" class="form-label"><strong>Key (a-z):</strong></label>
        <input type="text" id="key" name="key" value="<?= htmlspecialchars($_POST['key'] ?? '') ?>" class="form-control" required pattern="[a-zA-Z]*">
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Encrypt</button>
    </form>
    <hr>
    <?php if (isset($cipherText)) : ?>
      <p>
        <strong><?= $cipherText ?></strong>
      </p>
      <p>
        <a href="/uploads/<?= $filename ?>" download>Download decrypted text file</a>
      </p>
    <?php else : ?>
      <p>
        <strong>Please input plain text and key</strong>
      </p>
    <?php endif ?>
  </div>
</div>

<?php include __DIR__ . '/../components/_footer.php'; ?>