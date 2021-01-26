<div class="{{$size}}">
    <div class="form-group">
        <label for="{{$name}}">{!! $label !!} {!! $required !!}</label>
        <select name="{{$name}}" id="{{$id}}" class="form-control {{($errors->first($name) ? 'is-invalid' : '')}}" {{$disabled}}">
            @if (empty($value))
                <option value="" selected disabled>---Select---</option>
            @else
                @if( $allowNullOption)
                    <option @if($value == null)selected="selected" @endif value="">-</option>
                @endif
            @endif
            @foreach($options as $optionValue => $optionLabel)
                <option @if($optionValue == old($name, $value)) selected @endif value="{{$optionValue}}">{{$optionLabel}}</option>
            @endforeach
        </select>

        @include('BlueAdminComponents::formelements._errorandcomment')
    </div>
</div>



@push('blueadmin_header')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('blueadmin_scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#{{$id}}').select2();
        });
    </script>
@endpush
