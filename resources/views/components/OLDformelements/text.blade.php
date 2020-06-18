{{-- resources/views/components/forms/text.blade.php --}}

@php
	$placeholder = (isset($placeholder)) ? $placeholder : '';
	$help = (isset($help)) ? $help : null;
	$value = (isset($m)) ? $m->$id : null;
@endphp


<div class="form-group @error($id)has-error @enderror" style="margin-top: 15px;">
  <label class="col-sm-2" for="{{$id}}">{{$label}}</label>
  <div class="col-sm-10">
  	@error('{{$id}}')<div class="alert alert-danger">{{ $message }}</div>@enderror
    <input type="text" class="form-control" id="{{$id}}" name="{{$id}}" placeholder="{{$placeholder}}" value="{{old($id, $value)}}">
    
    @error($id)
	    <p class="help-block" style="margin-left: 10px;"><small>@error($id){{$message}} @enderror <span class="text-muted">{{$help}}</span></small></p>
    @else
	    @if($help)
	    	<p class="help-block" style="margin-left: 10px;"><small>{!!$help!!}</small></p>
	    @endif
	@enderror
  
  </div>
</div>

<div class="clearfix"></div>