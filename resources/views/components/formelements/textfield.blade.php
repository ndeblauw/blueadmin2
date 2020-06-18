<div class="{{ $size }}">
    <div class="form-group">
        <label for="{{ $name }}">{!! $legend !!}&nbsp;{!! $required  !!}</label>
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $id }}"
            placeholder="{{ $placeholder }}"
            value="{{ old($name, $value) }}"
            class="form-control {{ ($errors->first($name) ? 'is-invalid' : '') }}"
        >
        @include('BlueAdminComponents::formelements._errorandcomment')
    </div>
</div>
