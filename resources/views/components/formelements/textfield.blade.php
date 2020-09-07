<div class="{{ $size }}">
    <div class="form-group">
        <label for="{{ $name }}">{!! $label !!}&nbsp;{!! $required  !!}</label>
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $id }}"
            placeholder="{{ $placeholder }}"
            value="{{ old($name, $value) }}"
            class="form-control {{ ($errors->first($name) ? 'is-invalid' : '') }}"
            {{$disabled}}
        >
        @include('BlueAdminComponents::formelements._errorandcomment')
    </div>
</div>
