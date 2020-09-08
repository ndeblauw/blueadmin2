<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

class Datepicker extends Component
{
    const TEMPLATE = 'datepicker';
    public bool $onlyDate;
    public bool $onlyTime;

    public function __construct(
        string $name,
        string $label = null,
        string $placeholder = null,
        string $comment = null,
        string $id = null,
        bool $required = false,
        bool $disabled = false,
        string $size = null,
        string $value = null,
        bool $onlyDate = false,
        bool $onlyTime = false
    ) {
        if ($onlyDate && $onlyTime) {
            abort(404, "You can't asign both onlyDate and onlyTime together...");
        }
        parent::__construct($name, $label, $placeholder, $id, $comment, $required, $size, $value, $disabled);
        $this->onlyDate = ($onlyDate) ? true : false;
        $this->onlyTime = ($onlyTime) ? true : false;

        $this->placeholder = $placeholder ?? ($onlyDate ? 'yyyy-mm-dd' : ($onlyTime ? 'hh:mm' : 'yyy-mm-dd hh:mm'));

        if ($onlyTime) {
            $this->value = substr($this->value,0,5);
        }
    }

}
