<?php

declare(strict_types = 1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumber implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)// phpcs:ignore
    {
        if ($value === null) {
            return true;
        }

        // phpcs:ignore
        return preg_match(
            // phpcs:ignore
            '/^(\+?31|00|0)(\s?)(-?)(\s?)(\(?)(\d)(\)?)(-?)((\s?)(\d)){8,10}$/',
            $value,
        );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()// phpcs:ignore
    {
        return ':input is geen geldig telefoonnummer';
    }
}
