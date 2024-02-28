<?php

require './affine-cipher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $plainText = $_POST['plain'] ?? '';
  $slope = $_POST['slope'] ?? '';
  $intercept = $_POST['intercept'] ?? '';

  if (Affine::checkRelativePrime($slope)) {
    $cipherText = Affine::encrypt($plainText, $slope, $intercept);
    $filename = 'encrypt-' . uniqid() . '.txt';
    file_put_contents(__DIR__ . '/../uploads/' . $filename, $cipherText);
  }
}

?>

<?php include __DIR__ . '/../components/_header.php' ?>

<div class="card position-absolute top-50 start-50 translate-middle">
  <div class="card-body">
    <a href="/index.php" class="btn btn-secondary mb-3">Back to home</a>
    <h5 class="card-title fs-3 text-center">Encrypt Affine Cipher</h5>
    <hr>
    <form method="post">
      <div class="my-3 form-group">
        <label for="plain" class="form-label"><strong>Plain text:</strong></label>
        <textarea id="plain" name="plain" class="form-control" required><?= htmlspecialchars($_POST['plain'] ?? '') ?></textarea>
      </div>
      <div class="my-3 form-group">
        <label for="slope" class="form-label"><strong>Slope:</strong></label>
        <input type="number" id="slope" name="slope" class="form-control" value="<?= htmlspecialchars($_POST['slope'] ?? '') ?>" min=1>
      </div>
      <div class=" my-3 form-group">
        <label for="intercept" class="form-label"><strong>Intercept (pergeseran):</strong></label>
        <input type="number" id="intercept" name="intercept" value="<?= htmlspecialchars($_POST['intercept'] ?? '') ?>" class="form-control" required min=0>
      </div>
      <button type="submit" name="submit" class="btn btn-primary w-100 p-2">Encrypt</button>
    </form>
    <hr>
    <?php if (isset($cipherText)) : ?>
      <p>
        <strong>Output:</strong> <?= $cipherText ?>
      </p>
      <p>
        <a href="/uploads/<?= $filename ?>" download>Download encrypted text file</a>
      </p>
      <p>
        <strong>Output (base64):</strong> <?= base64_encode($cipherText) ?>
      </p>
    <?php else : ?>
      <?php if (!empty($slope) && !Affine::checkRelativePrime($slope)) : ?>
        <div class="alert alert-danger text-center" role="alert">
          <?= $slope ?> is not relatively prime to 26!
        </div>
      <?php else : ?>
        <div class="alert alert-info text-center">
          <strong>Please input plain text, slope, intercept</strong>
        </div>
      <?php endif ?>
    <?php endif ?>
  </div>
</div>

<?php include __DIR__ . '/../components/_footer.php'; ?>