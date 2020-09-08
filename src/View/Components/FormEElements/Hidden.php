<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

class Hidden extends Component
{
    const TEMPLATE = 'hidden';

    public function __construct(
        string $name,
        string $value = null,
        string $id = null,
        $model = null
    ) {
        parent::__construct($name, null, null, $id, null, false, null, $value);
    }
}
