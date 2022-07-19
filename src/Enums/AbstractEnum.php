<?php

namespace ShoppingFlux\Zalando\Enums;

use ReflectionClass;

abstract class AbstractEnum {
  /**
   * Returns the list of all values
   *
   * @param array $exceptValues
   * @return array
   */
  public static function getValues(Array $exceptValues = []): array {
    $class = new ReflectionClass(get_called_class());
    $constants = $class->getConstants();

    if (!empty($exceptValues)){
      foreach ($constants as $index => $constant) {
        if (in_array($constant, $exceptValues)) {
          unset($constants[$index]);
        }
      }
    }

    return $constants;
  }
}
