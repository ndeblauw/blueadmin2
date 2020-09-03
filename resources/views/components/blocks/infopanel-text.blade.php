<div class="row">
    <div class="col-12 col-md-2 text-secondary text-right font-weight-light">{{ $label }}</div>
    <div class="col-12 col-md-10">
        @if( $link === null )
            {{ $value }}
        @else
            <a href="{{ $link }}" target=" _blank">{{ $value }}</a>
        @endif
    </div>
</div>
