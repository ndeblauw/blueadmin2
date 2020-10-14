<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

class FileUpload extends Component
{
    const TEMPLATE = 'fileupload';

    public function __construct(
        string $name,
        string $label = null,
        string $comment = null,
        string $id = null,
        bool $required = false,
        bool $disabled = false,
        string $size = null,
        string $value = null
    ) {
        parent::__construct($name, $label, null, $id, $comment, $required, $size ?? 'col-12', $value, $disabled);
    }
}
