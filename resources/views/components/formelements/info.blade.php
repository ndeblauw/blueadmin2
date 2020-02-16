{{-- resources/views/components/forms/info.blade.php --}}

@php
	$id_field = (isset($id)) ? $id : 'id';
	$help = (isset($help)) ? $help : null;
	$link = (isset($link)) ? $link : null;

  $vars = get_defined_vars();
	$value = (array_key_exists('value', $vars)) ? $value : ( (isset($m)) ? $m->$id_field : null);
@endphp

@if($value)
<div class="form-group" style="margin-top: 15px;">
  <label class="col-sm-2">{{$label}}</label>
  <div class="col-sm-10">
  	@if($link)
  		<a href="{{$link}}">{!!$value!!}</a>
  	@else
	    {!! $value!!}
	@endif

	@if($help)
    	<p class="help-block" style="margin-left: 10px;"><small>{!!$help!!}</small></p>
    @endif
  </div>
</div>

<div class="clearfix"></div>
@endif
