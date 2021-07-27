<?php


namespace App\Traits;

use Illuminate\Support\Str;

/**
 * Trait GenerateUuid
 *
 * @package App\Traits
 */
trait GenerateUuid
{
  /**
   * Generate uuid.
   *
   * @return void
   */
  protected static function bootGenerateUuid(): void
  {
    static::creating(fn($model) => $model->{$model->getKeyName()} = $model->{$model->getKeyName()} ?: (string) Str::orderedUuid());
  }
}
