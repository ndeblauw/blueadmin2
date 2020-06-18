<div class="{{$size}}">
    <div class="form-group">
        <label for="{{$legend}}">{{$legend}}{!! $required !!}</label>
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input" id="{{$id}}" name="{{$name}}" value="1"
                       @if(old($name,$value))) checked @endif >
                {{$label}}
            </label>
        </div>
        @include('BlueAdminComponents::formelements._errorandcomment')
    </div>
</div>
