{{-- resources/views/components/forms/info.blade.php --}}

@php
	$id_field = (isset($id)) ? $id : 'id';
	$value = (isset($m)) ? $m->$id_field : null;
@endphp

@if($value)
<div class="form-group" style="margin-top: 15px;">
  <label class="col-sm-2">{{$label}}</label>
  <div class="col-sm-10">
    {{$value}}
  </div>
</div>
<div class="clearfix"></div>
@endif