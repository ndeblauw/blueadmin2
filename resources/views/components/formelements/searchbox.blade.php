<div class="{{$size}}">
    <div class="form-group">
        <label for="{{$name}}">{!! $label !!} {!! $required !!}</label>
        <select name="{{$name}}" id="{{$id}}" class="form-control {{($errors->first($name) ? 'is-invalid' : '')}}" {{$disabled}}>
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
    <link rel="stylesheet" href="{{ asset('lteadmin/css/select2.css')}}">
@endpush

@push('blueadmin_scripts')
    <script src="{{asset('lteadmin/js/select2.full.js')}}"></script>
    <script>
        $(document).ready(function () {

            $('#{{$id}}').select2({
                matcher: function (params, data) {
                    // If there are no search terms, return all of the data
                    if ($.trim(params.term) === '') { return data; }

                    // Do not display the item if there is no 'text' property
                    if (typeof data.text === 'undefined') { return null; }

                    // `params.term` is the user's search term
                    // `data.id` should be checked against
                    // `data.text` should be checked against
                    var q = params.term.toLowerCase();
                    if (data.text.toLowerCase().indexOf(q) > -1 || data.id.toLowerCase().indexOf(q) > -1) {
                        return $.extend({}, data, true);
                    }

                    // Return `null` if the term should not be displayed
                    return null;
                }
            });

            // make border red when error
            @if($errors->first($name))
            $('#{{$id}}').next().find('.select2-selection').addClass('has-error');
            @endif
        });
    </script>

@endpush