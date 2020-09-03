<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

use Ndeblauw\BlueAdmin\FormDataBinder;

trait HandlesBoundModel
{
    /*
     *  Idea from https://github.com/protonemedia/laravel-form-components
     */

    /**
     * Get an instance of FormDataBinder.
     * @return FormDataBinder
     */
    private function getFormDataBinder(): FormDataBinder
    {
        return app(FormDataBinder::class);
    }

    /**
     * Get the latest bound target.
     * @return mixed
     */
    private function getBoundTarget()
    {
        return $this->getFormDataBinder()->get();
    }

    /**
     * Get an item from the latest bound target.
     * @param mixed $bind
     * @param string $name
     * @return mixed
     */
    private function getBoundValue($bind = null, string $name)
    {
        if ($bind === false) {
            return null;
        }

        $bind = $bind ?: $this->getBoundTarget();

        return data_get($bind, $name);
    }
}
