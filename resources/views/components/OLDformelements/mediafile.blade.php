{{-- resources/views/components/forms/mediafile.blade.php --}}

@php
	$placeholder = (isset($placeholder)) ? $placeholder : '';
	$help = (isset($help)) ? $help : null;
	$value = (isset($m)) ? $m->$id : null;
@endphp


<div class="form-group @error($id)has-error @enderror" style="margin-top: 15px;">
  <label class="col-sm-2" for="{{$id}}">{{$label}}</label>
  <div class="col-sm-10">
  	@error('{{$id}}')<div class="alert alert-danger">{{ $message }}</div>@enderror
    
	@if( isset($m) && ($m->getMedia($id)->count() <> 0) )
		<img src="{{ $m->getFirstMediaUrl($id, 'thumbnail') }}" style="margin-bottom: 3px;"> <span class="text-muted">Uploading a new {{$id}} will automatically remove this file.
	@endif

    <input type="file" class="form-control" id="{{$id}}" name="{{$id}}" value="{{old($id, $value)}}">

    
    @error($id)
	    <p class="help-block" style="margin-left: 10px;">@error($id){{$message}} @enderror <span class="text-muted">{{$help}}</span></p>
    @else
	    @if($help)
	    	<p class="help-block" style="margin-left: 10px;">{!!$help!!}</p>
	    @endif
	@enderror
  
  </div>
</div>

<div class="clearfix"></div>



