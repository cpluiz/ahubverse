<li class="nav-item">
    <a href="{{route('dashboard')}}" class="nav-link {{Route::currentRouteName() === 'dashboard' ? 'active' : ''}}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{route('users')}}" class="nav-link {{Route::currentRouteName() === 'users' ? 'active' : ''}}">
        <i class="nav-icon fas fa-users-cog"></i>
        <p>Usuários</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{route('channels')}}" class="nav-link {{Route::currentRouteName() === 'channels' ? 'active' : ''}}">
        <i class="nav-icon fab fa-twitch"></i>
        <p>Canais</p>
    </a>
</li>
