@guest
    <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}"><h6>CONNEXION</h6></a>
    </li>
    @if (Route::has('register'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}"><h6>INSCRIPTION</h6></a>
    </li>
    @endif
@else
<li class="nav-item">
    <div class="hidden sm:flex sm:items-center sm:ml-6">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <h6>{{ Auth::user()->name }}</h6> <span class="caret"></span>
                </a>
            </x-slot>

            <x-slot name="content">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="dropdown-item" href="{{ route('dashboard') }}"><h6>Mes commandes</h6></a>
                    <a class="dropdown-item" href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"><h6>
                        {{ __('Deconnexion') }}
                </h6></a>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</li>
@endguest

