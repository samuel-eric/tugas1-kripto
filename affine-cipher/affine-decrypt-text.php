<?php

require './affine-cipher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $cipherText = $_POST['cipher'] ?? '';
  $slope = $_POST['slope'] ?? '';
  $intercept = $_POST['intercept'] ?? '';
  $plainText = Affine::decrypt($cipherText, $slope, $intercept);
}

?>

<?php include __DIR__ . '/../components/_header.php' ?>

<div class="card position-absolute top-50 start-50 translate-middle">
  <div class="card-body">
    <a href="/index.php" class="btn btn-secondary mb-3">Back to home</a>
    <h5 class="card-title fs-3">Decrypt Affine Cipher</h5>
    <hr>
    <form method="post">
      <div class="my-3">
        <label for="cipher" class="form-label"><strong>Cipher text:</strong></label>
        <input type="text" id="cipher" name="cipher" value="<?= htmlspecialchars($_POST['cipher'] ?? '') ?>" class="form-control">
      </div>
      <div class="my-3">
        <label for="slope" class="form-label"><strong>Slope:</strong></label>
        <select name="slope" id="slope" class="form-select">
          <?php foreach (Affine::$slopeOption as $slope) : ?>
            <option value="<?= $slope ?>" <?= isset($_POST['slope']) && $slope == $_POST['slope'] ? 'selected' : '' ?>><?= $slope ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="my-3">
        <label for="intercept" class="form-label"><strong>Intercept (pergeseran):</strong></label>
        <input type="text" id="intercept" name="intercept" value="<?= htmlspecialchars($_POST['intercept'] ?? '') ?>" class="form-control">
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
        <strong>Please input cipher text, slope, and intercept</strong>
      </p>
    <?php endif ?>
  </div>
</div>

<?php include __DIR__ . '/../components/_footer.php'; ?>

<div>
  <a href="/index.php">Back to home</a>
</div>
<h1>Decrypt Affine Cipher</h1>
<form method="post">
  <div>
    <label for="cipher">Cipher text:</label>
    <input type="text" id="cipher" name="cipher">
  </div>
  <div>
    <label for="slope">Slope: </label>
    <select name="slope" id="slope">
      <option value="1">1</option>
      <option value="3">3</option>
      <option value="5">5</option>
      <option value="7">7</option>
      <option value="9">9</option>
      <option value="11">11</option>
      <option value="15">15</option>
      <option value="17">17</option>
      <option value="19">19</option>
      <option value="21">21</option>
    </select>
  </div>
  <div>
    <label for="intercept">Intercept (pergeseran):</label>
    <input type="number" id="intercept" name="intercept">
  </div>
  <button type="submit" name="submit">Decrypt</button>
</form>
<?php if (isset($plainText)) : ?>
  <p>
    <strong><?= $plainText ?></strong>
  </p>
<?php else : ?>
  <p>
    <strong>Please input some text</strong>
  </p>
<?php endif ?>
</body>

</html>