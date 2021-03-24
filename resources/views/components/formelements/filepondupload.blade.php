<div class="{{ $size }}">
    <div class="form-group">
        <label for="{{ $name }}">{!! $label !!}&nbsp;{!! $required  !!}</label>
        Upload {{ $multiple ? 'multiple files' : 'one file'}} {{ ($maxFiles !== null) ? '(max '.$maxFiles.')' : '' }}

        <input
                type="file"
                name="{{ $multiple ? $name.'[]' : $name}}"
                id="{{ $id }}"
                value="{{old($id, $value)}}"
                class="filepond {{ ($errors->first($name) ? 'is-invalid' : '') }}"
                {{ $multiple ? 'multiple' : '' }}
                {!! $multiple ? 'data-allow-reorder="true"' : '' !!}
        >
        @include('BlueAdminComponents::formelements._errorandcomment')
    </div>
</div>


@push('blueadmin_header')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
@endpush

@push('blueadmin_scripts')
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        const inputElement = document.querySelector('.filepond');
        const pond = FilePond.create( inputElement );
        FilePond.setOptions({
            @if($maxFiles !== null) maxFiles: {{$maxFiles}},@endif
            server: {
                url: '{{route('filepond.upload')}}',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                },
            },
            @if( isset($model) && ($model->getMedia($name) !== null) )
            files: [
                @foreach($model->getMedia($name) as $existingFile)
                {
                    // the server file reference
                    source: 'existing_file_{{$existingFile->id}}',

                    // set type to local to indicate an already uploaded file
                    options: {
                        type: 'local',

                        // mock file information
                        file: {
                            name: '{{$existingFile->name}}',
                            size: {{$existingFile->size}},
                            type: '{{$existingFile->mime_type}}'
                        }
                    }
                },
                @endforeach
            ],
            @endif
        });

    </script>
@endpush
