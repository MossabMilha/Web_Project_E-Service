<div class="profile-dropdown">
    <button class="profile-button" id="profileDropdownButton">
        <img src="{{$image}}" alt="Profile" class="profile-image" onerror="this.src='{{ asset('png/dead.png') }}'">
        <span class="profile-name">{{ $name }}</span>
        <i class="fas fa-caret-down"></i>
    </button>
    <div class="dropdown-menu" id="dropdownMenu">
        @if($email)
        <div class="dropdown-header">
            <h6>{{ $name }}</h6>
            <small>{{ $email }}</small>
        </div>
        <div class="dropdown-divider"></div>
        @endif

        @foreach($items as $item)
            @if($item == 'divider')
                <div class="dropdown-divider"></div>
            @else
            <a href="{{ $item['url'] }}" class="dropdown-item" @if(isset($item['method'])) onclick="event.preventDefault(); document.getElementById('logout-form').submit();" @endif>
                <img src="{{ $item['image'] }}" alt="icon image"> {{ $item['text'] }}
                @if(isset($item['badge']) && $item['badge'] > 0)
                    <span class="badge">{{ $item['badge'] }}</span>
               @endif
            </a>
            @endif
        @endforeach
    </div>

    @if(isset($item['method']) && $item['method'] === 'POST')
    <form id="logout-form" action="{{ $item['url'] }}" method="POST" style="display: none;">
        @csrf
    </form>
    @endif
</div>
