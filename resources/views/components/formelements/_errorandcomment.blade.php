@if ($errors->first($name))
    <span class="text-danger mt-5 ml-2" style="font-weight: 300;">
        <i class="fas fa-exclamation-triangle"></i>&nbsp;
        {{ $errors->first($name)}}
    </span>
@endif
