<div class="{{$size}}">
    <div class="form-group">
        <label for="{{$name}}">{!! $label !!} {!! $required !!}</label>

        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">Select all</span>
        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">Deselect all</span>

        <select name="{{$name}}[]" id="{{$id}}" multiple class="form-control {{($errors->first($name) ? 'is-invalid' : '')}}" {{$disabled}}>
            @foreach($options as $optionValue => $optionLabel)
                <option @if(in_array($optionValue, old($name,$values))) selected @endif value="{{$optionValue}}">{{$optionLabel}}</option>
            @endforeach
        </select>
        @include('BlueAdminComponents::formelements._errorandcomment')
    </div>
</div>

@push('blueadmin_header')
    <link rel="stylesheet" href="{{ asset('lteadmin/css/select2.css')}}">
@endpush

@push('blueadmin_scripts')
    <script src="{{asset('lteadmin/js/select2.full.js')}}"></script>
    <script>
        $(document).ready(function () {
            console.log('hallo');
            $("#{{$id}}").select2();

            // select all elements
            $(".select-all").click(function(){
                $("#{{$id}} > option").prop("selected","selected");
                $("#{{$id}}").trigger("change");
            });

            // de-select all elements
            $(".deselect-all").click(function(){
                $('#{{$id}}').val('').trigger('change');
            });

            // make border red when error
            @if($errors->first($name))
            $('#{{$id}}').next().find('.select2-selection').addClass('has-error');
            @endif
        });
    </script>
@endpush


