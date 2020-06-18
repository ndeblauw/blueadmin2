{{-- resources/views/components/forms/text.switch.php --}}

@php
	$placeholder = (isset($placeholder)) ? $placeholder : 'dd';
	$help = (isset($help)) ? $help : null;
  $value = (isset($m)) ? ($m->$id ? 1 : 0) : null;
@endphp


<div class="form-group" style="margin-top: 15px;">
  <label class="col-sm-2">{{$label}} </label>
  <div class="col-sm-10">
    <div class="checkbox" style="margin-top: 0px; padding-left: 25px;">
        <input type="checkbox" name="{{$id}}" id="{{$id}}" @if($value==1)checked @endif> Yes

	    @if($help)
	    	<p class="help-block" style="margin-left: -15px;">{{$help}}</p>
	    @endif

    </div>
  </div>
  <div class="col-sm-12" style="height: 10px;">&nbsp;</div>
</div>
