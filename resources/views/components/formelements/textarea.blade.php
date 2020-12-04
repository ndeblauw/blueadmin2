<div class="{{ $size }}">
    <div class="form-group">
        <label for="{{ $name }}">{!! $label !!}&nbsp;{!! $required  !!}</label>
        <textarea
            name="{{ $name }}"
            id="{{ $id }}"
            rows="{{ $rows }}"
            placeholder="{{ $placeholder }}"
            class="form-control form-control {{ $rte ? 'tinymce' : '' }} {{ ($errors->first($name) ? "is-invalid" : "") }}"
            {{$disabled}}
        >{{ old($name, $value) }}</textarea>
        @include('BlueAdminComponents::formelements._errorandcomment')
    </div>
</div>

@if($rte)
    @push('blueadmin_scripts')
        <script src="/lteadmin/vendor/tinymce/tinymce.min.js"></script>
        <script>
            var editor_config = {
                relative_urls : false,
                path_absolute: "{{ URL::to('/') }}/",
                selector: '.tinymce',
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor textcolor',
                    'searchreplace visualblocks fullscreen',
                    'contextmenu paste help wordcount code'
                ],
                toolbar: ' undo redo |  bold italic | link | alignleft aligncenter alignright alignjustify | numlist bullist | outdent indent | removeformat | code | help',
            }
            tinymce.init(editor_config);
        </script>
    @endpush
@endif
