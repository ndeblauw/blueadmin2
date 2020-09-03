@if( $errors->first($name) )
    <span class="text-danger mt-5 ml-2" style="font-weight: 300;">
        <i class="fas fa-exclamation-triangle"></i>&nbsp;
        {{ $errors->first($name) }}
    </span>
@elseif( $comment ?? null)
    <span class="text-secondary mt-5 ml-2" style="font-weight: 300;">
         {!! $comment ?? '' !!}
    </span>
@endif
