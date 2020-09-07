

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
