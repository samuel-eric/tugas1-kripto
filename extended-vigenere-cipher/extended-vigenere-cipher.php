<?php

class ExtendedVigenere
{
  public static function encrypt($file, $key)
  {
    $plainFile = file_get_contents($file['tmp_name']);
    while (strlen($plainFile) > strlen($key)) {
      $key .= $key;
    }
    while (strlen($plainFile) < strlen($key)) {
      $key = substr($key, 0, strlen($key) - 1);
    }

    $plainFileArr = str_split($plainFile);
    $keyArr = str_split($key);

    $plainValues = [];
    $keyValues = [];

    foreach ($plainFileArr as $plain) {
      $plainValues[] = ord($plain);
    }

    foreach ($keyArr as $keyItem) {
      $keyValues[] = ord($keyItem);
    }

    $cipherValues = [];

    for ($i = 0; $i < count($plainValues); $i++) {
      $cipherValues[] = ($plainValues[$i] + $keyValues[$i]) % 256;
    }


    // convert cypher values to cypher text
    $cipherFile = '';
    foreach ($cipherValues as $value) {
      $cipherFile .= chr($value);
    }

    // var_dump($plainFile === $cipherFile);

    $tmp = explode('.', $file['name']);
    $ext = end($tmp);

    file_put_contents(__DIR__ . "/../uploads/encrypt.$ext", $cipherFile);
  }

  public static function decrypt($file, $key)
  {
    $cipherFile = file_get_contents($file['tmp_name']);
    while (strlen($cipherFile) > strlen($key)) {
      $key .= $key;
    }
    while (strlen($cipherFile) < strlen($key)) {
      $key = substr($key, 0, strlen($key) - 1);
    }

    $cipherFileArr = str_split($cipherFile);
    $keyArr = str_split($key);

    $cipherValues = [];
    $keyValues = [];

    foreach ($cipherFileArr as $cipher) {
      $cipherValues[] = ord($cipher);
    }

    foreach ($keyArr as $keyItem) {
      $keyValues[] = ord($keyItem);
    }

    $plainValues = [];

    for ($i = 0; $i < count($cipherValues); $i++) {
      $plainValue = ($cipherValues[$i] - $keyValues[$i]) % 256;
      $plainValues[] = $plainValue < 0 ? $plainValue += 256 : $plainValue;
    }

    // convert cypher values to cypher text
    $plainFile = '';
    foreach ($plainValues as $value) {
      $plainFile .= chr($value);
    }

    $tmp = explode('.', $file['name']);
    $ext = end($tmp);

    file_put_contents(__DIR__ . "/../uploads/decrypt.$ext", $plainFile);
  }
}
