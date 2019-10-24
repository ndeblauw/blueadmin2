{{-- resources/views/components/forms/belongsto.blade.php --}}

@php
  $placeholder = (isset($placeholder)) ? $placeholder : 'dd';
  $help = (isset($help)) ? $help : null;
  $value = (isset($value)) ? $value : null;
@endphp

<div class="form-group @error($id)has-error @enderror" style="margin-top: 15px;">
  <label class="col-sm-2" for="{{$id}}">{{$label}}</label>
  <div class="col-sm-10">
    @error('{{$id}}')<div class="alert alert-danger">{{ $message }}</div>@enderror

    <select id="{{$id}}" name="{{$id}}" class="form-control select2" style="width: 50%;">
      <option @if($value == null) selected="selected" @endif value="">-</option>
      @foreach($list as $key => $item)
        <option @if($value == $key) selected="selected" @endif value={{$key}}>{{$item}}</option>
      @endforeach
    </select>

    
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