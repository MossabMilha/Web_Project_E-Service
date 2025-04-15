<header class="header-user" style="background-image: {{ $backgroundUrl ? 'url(' . asset($backgroundUrl) . ')' : 'none' }}">
    <div class="path">
        <a href="">home</a>
        <span>></span>
        <a href="">dashboard</a>
    </div>
    <h1>Welcome, {{$username}}!</h1>
    <div class="role"><h2>{{$userrole}}</h2></div>
</header>
