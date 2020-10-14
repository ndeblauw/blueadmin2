<div class="{{ $size }}">
    <div class="form-group">
        <label for="{{ $name }}">{!! $label !!}&nbsp;{!! $required  !!}</label>

        <input
                type="file"
                name="{{$id}}"
                id="{{ $id }}"
                value="{{old($id, $value)}}"
                class="form-control {{ ($errors->first($name) ? 'is-invalid' : '') }}"
        >
        @include('BlueAdminComponents::formelements._errorandcomment')
    </div>
</div>
