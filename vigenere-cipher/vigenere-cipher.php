<?php

class Vigenere
{
  public static function encrypt($plainText, $key)
  {
    $alphabets = range('a', 'z');

    $plainText = implode(explode(' ', $plainText));
    $key = implode(explode(' ', $key));

    while (strlen($plainText) > strlen($key)) {
      $key .= $key;
    }
    while (strlen($plainText) < strlen($key)) {
      $key = substr($key, 0, strlen($key) - 1);
    }

    $plainTextArr = str_split(strtolower($plainText));
    $keyArr = str_split(strtolower($key));

    $plainValues = [];
    $keyValues = [];

    foreach ($plainTextArr as $plain) {
      foreach ($alphabets as $index => $alphabet) {
        if ($alphabet === $plain) {
          $plainValues[] = $index;
        }
      }
    }

    foreach ($keyArr as $keyItem) {
      foreach ($alphabets as $index => $alphabet) {
        if ($alphabet === $keyItem) {
          $keyValues[] = $index;
        }
      }
    }

    $cipherValues = [];

    for ($i = 0; $i < count($plainValues); $i++) {
      $cipherValues[] = ($plainValues[$i] + $keyValues[$i]) % 26;
    }


    // convert cypher values to cypher text
    $cipherText = '';
    foreach ($cipherValues as $value) {
      foreach ($alphabets as $index => $alphabet) {
        if ($value === $index) {
          $cipherText .= $alphabet;
        }
      }
    }

    return $cipherText;
  }

  public static function decrypt($cipherText, $key)
  {
    $alphabets = range('a', 'z');

    $cipherText = implode(explode(' ', $cipherText));
    $key = implode(explode(' ', $key));

    while (strlen($cipherText) > strlen($key)) {
      $key .= $key;
    }
    while (strlen($cipherText) < strlen($key)) {
      $key = substr($key, 0, strlen($key) - 1);
    }


    $cipherTextArr = str_split(strtolower($cipherText));
    $keyArr = str_split(strtolower($key));

    $cipherValues = [];
    $keyValues = [];

    foreach ($cipherTextArr as $cipher) {
      foreach ($alphabets as $index => $alphabet) {
        if ($alphabet === $cipher) {
          $cipherValues[] = $index;
        }
      }
    }

    foreach ($keyArr as $keyItem) {
      foreach ($alphabets as $index => $alphabet) {
        if ($alphabet === $keyItem) {
          $keyValues[] = $index;
        }
      }
    }

    $plainValues = [];

    for ($i = 0; $i < count($cipherValues); $i++) {
      $plainValue = ($cipherValues[$i] - $keyValues[$i]) % 26;
      $plainValues[] = $plainValue < 0 ? $plainValue += 26 : $plainValue;
    }

    // convert cypher values to cypher text
    $plainText = '';
    foreach ($plainValues as $value) {
      foreach ($alphabets as $index => $alphabet) {
        if ($value === $index) {
          $plainText .= $alphabet;
        }
      }
    }

    return $plainText;
  }
}
