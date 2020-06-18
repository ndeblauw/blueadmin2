<!-- Navbar up -->
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    @foreach($topbarMenu as $title => $link)
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ $link }}" class="nav-link">{{ ucfirst($title) }}</a>
        </li>
    @endforeach
</ul>

<!-- SEARCH FORM -->
@if( $globalSearch )
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
@endif
