<div class="{{ $size }}">
    <div class="form-group">
        <label>{!! $label !!}</label>
        <div>
            @if($link<>'')
                @if($icon)
                    {{ $value }}<a href="{{$link}}">&nbsp;<i class="fas fa-external-link-alt"></i></a>
                @else
                    <a href="{{$link}}">{{ $value }}</a>
                @endif
            @else
                {{ $value }}
            @endif
        </div>
        @include('BlueAdminComponents::formelements._errorandcomment')
    </div>
</div>
