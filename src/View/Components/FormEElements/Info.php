<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

class Info extends Component
{
    const TEMPLATE = 'info';
    public string $link;
    public bool $newWindow;
    public bool $icon;

    public function __construct(
        string $name = '',
        string $label,
        string $comment = null,
        string $id = null,
        string $size = null,
        $value = null,
        string $link = null,
        bool $newWindow = false,
        bool $icon = false
    )
    {
        // Check if there is a belongsTo relation (name = relation.fieldname)
        if (sizeof($arr=explode(".", $name, 2)) > 1) {
            $value = $value ?: $this->getBoundTarget()->{$arr[0]}->{$arr[1]};
        }

        parent::__construct($name, $label, null, $id, $comment, null, $size, $value);

        $this->link = $link ?? '';
        $this->newWindow = $newWindow;
        $this->icon = $icon;
    }
}
