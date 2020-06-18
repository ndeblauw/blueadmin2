<section class="{{$col}}">
    <!-- Custom tabs (Charts with tabs)-->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                @if($headerIcon) <i class="{{$headerIcon}} mr-1"></i> @endif
                {!! $headerTitle !!}
            </h3>
            <div class="card-tools">
                @if($cardTools){!! $cardTools !!}@endif
            </div>
        </div><!-- /.card-header -->

        <div class="card-body {{ $noPadding ? 'p-0' : ''}} ">
            <div class="tab-content p-0">

                {{$slot}}

            </div>
        </div><!-- /.card-body -->

        @isset($footer)
            <div class="card-footer">
                {{$footer}}
            </div><!-- /.card-footer -->
        @endisset
    </div>
</section>
