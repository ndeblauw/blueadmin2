<div class="{{$size}}">
    <div class="form-group">
        <label for="{{ $name }}">{!! $label !!}&nbsp;{!! $required  !!}</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
            <input type="text" value="{{ old($name, $value) }}" name="{{$name}}"
                   class="form-control float-right {{($errors->first($name) ? "is-invalid" : "")}}" id="{{$id}}">

        </div>
        @include('BlueAdminComponents::formelements._errorandcomment')
    </div>
</div>


@push('blueadmin_header')
    <link rel="stylesheet" href="{{ asset('lteadmin/css/tail.datetime-default-blue.css') }}">
@endpush

@push('blueadmin_scripts')
    <script src="{{ asset('lteadmin/js/tail.datetime-full.js') }}"></script>
    <script>
        tail.DateTime("#{{$id}}");
    </script>
@endpush
