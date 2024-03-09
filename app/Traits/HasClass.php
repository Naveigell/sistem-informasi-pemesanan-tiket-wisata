<?php

namespace App\Traits;

trait HasClass
{
    /**
     * Get the name of the called class
     *
     * @return string
     */
    public function getCalledClass()
    {
        return get_called_class();
    }
}
