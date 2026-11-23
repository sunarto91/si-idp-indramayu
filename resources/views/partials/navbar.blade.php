<nav class="navbar navbar-dark navbar-custom px-4 py-3">

    <a class="navbar-brand" href="{{ route('dashboard') }}">
        <i class="bi bi-bank me-2"></i>
        SI-IDP Indramayu
    </a>

    <div class="d-flex align-items-center gap-3">

        <span class="text-white small">
            <i class="bi bi-person-circle me-1"></i>
            {{ auth()->user()->name }}
        </span>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit"
                    class="btn btn-outline-light btn-sm">

                <i class="bi bi-box-arrow-right"></i>
                Logout

            </button>

        </form>

    </div>

</nav>
