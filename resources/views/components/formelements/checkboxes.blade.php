<div class="{{$size}}">
    <div class="form-group">
        <label for="{{$name}}">{{$label}}{!! $required !!}</label>
        @if($inline) inlien komt @endif
        @foreach($options as $optionValue => $optionLabel)
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" id="{{$id}}" name="{{$name}}[]" value="{{$optionValue}}"
                           @if(in_array($optionValue, old($name,$values))) checked @endif >
                    {{$optionLabel}}
                </label>
            </div>
        @endforeach
        @include('BlueAdminComponents::formelements._errorandcomment')
    </div>
</div>
