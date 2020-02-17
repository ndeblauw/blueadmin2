{{-- resources/views/components/forms/select2.blade.php --}}

@php
  $placeholder = (isset($placeholder)) ? $placeholder : '';
  $help = (isset($help)) ? $help : null;
  $value = (isset($m)) ? $m->$id : (isset($value) ? $value : null);
  $allowNullOption = (isset($allowNullOption)) ? true : false;
@endphp


@if($errors->any())
<hr/>
   @foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
  @endforeach
  <hr/>
@endif



<div class="form-group @error($id)has-error @enderror" style="margin-top: 15px;">
  <label class="col-sm-2" for="{{$id}}">{{$label}}</label>
  <div class="col-sm-10">
    @error('{{$id}}')<div class="alert alert-danger">{{ $message }}</div>@enderror

    <select id="{{$id}}" name="{{$id}}" class="form-control select2" style="width: 50%;">
      @if(! is_null($value) )
        <option selected="selected" value="{{$value}}">{{ $string_value = \App\Location::find($value)->name }} </option>
      @endif


{{--      
      @if( $allowNullOption)
        <option @if($value == null)selected="selected" @endif value="">-</option>
      @endif
      @foreach($list as $key => $item)
        <option value="{{$key}}" @if($value == $key) selected="selected" @endif>{{$item}}</option>
      @endforeach
--}}      
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


@push('blueadmin_scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script type="text/javascript">

$(document).ready(function(){
    //Initialize Select2 Elements
    //$('.select2').select2()

$( "#{{$id}}" ).select2({
        ajax: { 
          url: "{{$select2DataUrl}}",
          type: "get",
          dataType: 'json',
          delay: 150,
          data: function (params) {
            return {
              search: params.term // search term
            };
          },
          processResults: function (response) {
            return {
              results: response
            };
          },
          cache: true
        }

      });    
  });

</script>

@endpush