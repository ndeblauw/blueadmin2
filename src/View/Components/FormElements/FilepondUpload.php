<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

class FilepondUpload extends Component
{
    const TEMPLATE = 'filepondupload';
    public $multiple;
    public $maxFiles;

    public function __construct(
        string $name,
        string $label = null,
        string $comment = null,
        string $id = null,
        bool $required = false,
        bool $disabled = false,
        string $size = null,
        string $value = null,
        bool $multiple = false,
        int $maxFiles = null
    ) {
        parent::__construct($name, $label, null, $id, $comment, $required, $size ?? 'col-9', $value, $disabled);
        $this->multiple = $multiple;
        $this->maxFiles = $maxFiles;
    }
}
