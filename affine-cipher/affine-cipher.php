<?php

class Affine
{
  private static function findInverseSlope($slope)
  {
    $i = 1;
    while (($slope * $i) % 26 !== 1) {
      $i++;
    }
    return $i;
  }

  public static function encrypt($plainText, $slope, $intercept)
  {
    $alphabets = range('a', 'z');

    $plainTextArr = str_split(strtolower($plainText));

    $plainValues = [];

    foreach ($plainTextArr as $plain) {
      foreach ($alphabets as $index => $alphabet) {
        if ($alphabet === $plain) {
          $plainValues[] = $index;
        }
      }
    }

    $cipherValues = [];

    foreach ($plainValues as $plainValue) {
      $cipherValues[] = ($slope * $plainValue + $intercept) % 26;
    }

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

  public static function decrypt($cipherText, $slope, $intercept)
  {
    $alphabets = range('a', 'z');

    $cipherTextArr = str_split(strtolower($cipherText));

    $cipherValues = [];

    foreach ($cipherTextArr as $cipher) {
      foreach ($alphabets as $index => $alphabet) {
        if ($alphabet === $cipher) {
          $cipherValues[] = $index;
        }
      }
    }

    $plainValues = [];
    $inverseSlope = Affine::findInverseSlope($slope);
    foreach ($cipherValues as $cipherValue) {
      $plainValue = ($inverseSlope * ($cipherValue - $intercept)) % 26;
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
