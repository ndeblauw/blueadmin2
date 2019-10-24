{{-- resources/views/components/forms/textarea.blade.php --}}

@php
	$placeholder = (isset($placeholder)) ? $placeholder : '';
	$help = (isset($help)) ? $help : null;
	$rows = (isset($rows)) ? $rows : 5;
	$value = (isset($m)) ? $m->$id : null;
@endphp



<div class="form-group @error($id)has-error @enderror" style="margin-top: 15px;">
  <label class="col-sm-2" for="{{$id}}">{{$label}}</label>
  <div class="col-sm-10">
    <textarea class="form-control" id="{{$id}}" name="{{$id}}" placeholder="{{$placeholder}}" rows="{{$rows}}">{{old($id,$value)}}</textarea>
    
    @error($id)
	    <p class="help-block" style="margin-left: 10px;">@error($id){{$message}} @enderror <span class="text-muted">{{$help}}</span></p>
    @else
	    @if($help)
	    	<p class="help-block" style="margin-left: 10px;">{{$help}}</p>
	    @endif
	@enderror
  
  </div>
</div>

<div class="clearfix"></div>