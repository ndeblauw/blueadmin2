<div class="{{ $size }}">
    <div class="form-group">
        <label for="{{ $name }}">{!! $label !!}&nbsp;{!! $required  !!}</label>
        @if($inline)<br/>@endif
        @foreach($options as $option => $label)
            <div class="form-check @if($inline)form-check-inline @endif">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="{{$name}}" value="{{$option}}" id="{{$name}}-{{$option}}"
                           @if($option == old($name, $value)) checked @endif >
                    {{$label}}
                </label>
            </div>
        @endforeach
        @include('BlueAdminComponents::formelements._errorandcomment')
    </div>
</div>

