{{-- resources/views/components/forms/hidden.blade.php --}}

@php
	$id_field = (isset($id)) ? $id : 'id';
	$vars = get_defined_vars();
	$value = (array_key_exists('value', $vars)) ? $value : ( (isset($m)) ? $m->$id_field : null);
@endphp

<input type="hidden" class="form-control" id="{{$id}}" name="{{$id}}" value="{{$value}}">