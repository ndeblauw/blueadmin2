<div class="{{ $size }}">
    <div class="form-group">
        <label for="{{ $name }}">{!! $label !!}&nbsp;{!! $required  !!}</label>
        <textarea
            name="{{ $name }}"
            id="{{ $id }}"
            rows="6"
            placeholder="{{ $placeholder }}"
            class="form-control form-control {{ ($errors->first($name) ? "is-invalid" : "") }}"
        >{{ old($name, $value) }}</textarea>
        @include('BlueAdminComponents::formelements._errorandcomment')
    </div>
</div>
