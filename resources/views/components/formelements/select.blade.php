<div class="{{$size}}">
    <div class="form-group">
        <label for="{{$legend}}">{!! $legend !!} {!! $required !!}</label>
        <select name="{{$name}}" id="{{$id}}" class="form-control {{($errors->first($name) ? 'is-invalid' : '')}}">
            @if (empty($value))
                <option value="" selected disabled>---Select---</option>
            @endif
            @foreach($options as $optionValue => $optionLabel)
                <option @if($optionValue == old($name, $value)) selected @endif value="{{$optionValue}}">{{$optionLabel}}</option>
            @endforeach
        </select>
        @include('BlueAdminComponents::formelements._errorandcomment')
    </div>
</div>
