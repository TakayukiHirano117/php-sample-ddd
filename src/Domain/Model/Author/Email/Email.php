<?php

namespace Domain\Model\Author\Email;

use Domain\Model\ValueObject;
use InvalidArgumentException;

final class Email extends ValueObject
{
  const MAX_LENGTH = 254; // RFC 5321で定義されたメールアドレスの最大長
  const MIN_LENGTH = 5;   // 最小の有効なメールアドレス "a@b.c" の長さ

  public function __construct(string $value)
  {
    parent::__construct($value);
  }

  protected function validate(mixed $value): void
  {
    if (!is_string($value)) {
      throw new InvalidArgumentException('Emailは文字列でなくてはいけません');
    }

    if ($this->isEmpty($value)) {
      throw new InvalidArgumentException('Emailは空ではいけません');
    }

    if ($this->isTooShort($value)) {
      throw new InvalidArgumentException('Emailは5文字以上である必要があります');
    }

    if ($this->isTooLong($value)) {
      throw new InvalidArgumentException('Emailは254文字以内である必要があります');
    }

    if (!$this->isValidFormat($value)) {
      throw new InvalidArgumentException('Emailの形式が正しくありません');
    }
  }

  private function isEmpty(string $value): bool
  {
    return trim($value) === '';
  }

  private function isTooLong(string $value): bool
  {
    return strlen($value) > self::MAX_LENGTH;
  }

  private function isTooShort(string $value): bool
  {
    return strlen($value) < self::MIN_LENGTH;
  }

  private function isValidFormat(string $value): bool
  {
    // 基本的なメール形式チェック
    // @記号が1つだけ存在し、@の前後に文字があることを確認
    if (substr_count($value, '@') !== 1) {
      return false;
    }

    $parts = explode('@', $value);
    if (count($parts) !== 2) {
      return false;
    }

    $localPart = $parts[0];
    $domainPart = $parts[1];

    // ローカル部分のチェック
    if (empty($localPart) || strlen($localPart) > 64) {
      return false;
    }

    // ドメイン部分のチェック
    if (empty($domainPart) || strlen($domainPart) > 253) {
      return false;
    }

    // ドメインにドットが含まれていることを確認
    if (strpos($domainPart, '.') === false) {
      return false;
    }

    // ドメインの最後がドットで終わっていないことを確認
    if (substr($domainPart, -1) === '.') {
      return false;
    }

    // 基本的な文字チェック（英数字、ドット、ハイフン、アンダースコア、プラス記号）
    $localPattern = '/^[a-zA-Z0-9._%+-]+$/';
    $domainPattern = '/^[a-zA-Z0-9.-]+$/';

    return preg_match($localPattern, $localPart) && preg_match($domainPattern, $domainPart);
  }
}
