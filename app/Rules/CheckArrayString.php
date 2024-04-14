<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckArrayString implements ValidationRule
{
    protected $options;

    public function __construct($options)
    {
        $this->options = $options;
    }

    public function validate(string $attribute, $value, Closure $fail): void
    {
        // Split the input string into an array of options
        $inputOptions = explode(',', $value);

        // Check if each option in the input is present in the predefined options
        foreach ($inputOptions as $inputOption) {
            if (!in_array(trim($inputOption), $this->options)) {
                $fail("$attribute contains one or more invalid options.");
                return;
            }
        }
    }
}
