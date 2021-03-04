<div class="{{ $size }}">
    <div class="form-group">
        <label for="{{ $name }}">{!! $label !!}&nbsp;{!! $required  !!}</label>

        @if( isset($model) && ($model->getMedia($name)->count() <> 0) )
            <div class="row">
                @if(in_array('thumbnail', $model->media->first()->generated_conversions))
                    <div class="col-4">
                        <img src="{{ $model->getFirstMediaUrl($name, 'thumbnail') }}" style="margin-bottom: 3px;">
                    </div>
                    <div class="col-8">
                        <span class="text-muted">Uploading a new {{$name}} will automatically remove this file.</span>
                    </div>
                @else
                    <div class="col-12">
                        {{$model->media->first()->name}}<br/>
                        <span class="text-muted">Uploading a new {{$name}} will automatically remove this file.</span>
                    </div>
                @endif
            </div>
        @endif
        <input
            type="file"
            name="{{$id}}"
            id="{{ $id }}"
            value="{{old($id, $value)}}"
            class="form-control {{ ($errors->first($name) ? 'is-invalid' : '') }}"
        >
        @include('BlueAdminComponents::formelements._errorandcomment')
    </div>
</div>
