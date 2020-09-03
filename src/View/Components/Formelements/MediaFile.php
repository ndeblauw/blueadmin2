<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

class MediaFile extends Component
{
    const TEMPLATE = 'mediafile';

    public function __construct(
        string $name,
        string $label = null,
        string $comment = null,
        string $id = null,
        bool $required = false,
        string $size = null,
        string $value = null
    ) {
        parent::__construct($name, $label, null, $id, $comment, $required, $size ?? 'col-12', $value);
    }
}
