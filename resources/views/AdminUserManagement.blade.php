<x-layout title="User Management">
    <x-slot:head>
        @vite([
            // css files
            'resources/css/components/table.css',
            'resources/css/AdminUserManagement.css',
            // js files
            // 'resources/js/components/user-role-styling.js' // TODO: use this instead of AdminUserManagement.js
            'resources/js/AdminUserManagement.js',
        ])
    </x-slot:head>

    <x-nav/>

    {{--  body  --}}
    <div class="main-container">
        <div class="search-wrapper"> {{--  TODO: make a search component that work with dropdown components--}}
            <form class="search-form" method="GET" action="{{route('UserManagement.search')}}">
                <div class="search-bar">
                    <input type="text" id="search" name="search" placeholder="Search">
                    <button class="submit-btn" type="submit"><img src="{{ asset('svg/search-icon.svg') }}" alt="Search Icon"></button>
                </div>
                <div class="dropdown"> {{--  TODO: make dropdown component dynamic that work with any option--}}
                    <button id="OptionButton" onclick="toggleDropdown()">Select an Option</button>
                    <div class="dropdown-content">
                        <a href="#" onclick="selectOption('id')">id</a>
                        <a href="#" onclick="selectOption('full name')">full name</a>
                        <a href="#" onclick="selectOption('email')">email</a>
                        <a href="#" onclick="selectOption('role')">role</a>
                        <a href="#" onclick="selectOption('specialization')">specialization</a>
                    </div>
                </div>
                <input type="hidden" id="selectedOption" name="option" value="{{ request('option', 'id') }}">
            </form>
            <form class="add-user-form" method="GET" action="{{ route('UserManagement.adduser') }}">
                <button class="add-btn" type="submit">+ Add New User</button>
            </form>
        </div>
        <x-table> {{--TODO: think of a way to make a table component. You can do better :)--}}
            <table>
                <tr>
                    <th>User Id</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Specialisation</th>
                    <th>Account Created At</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><div class="role">{{$user->role}}</div></td>
                        <td>
                            @if($user->specialization == null)
                                N/A
                            @else
                                {{ $user->specialization }}
                            @endif
                        </td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td>
                            <a href="{{ route('UserManagement.user', $user->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/>
                                </svg>
                            </a>
                            <a href="#" onclick="showDeleteUserSection({{ $user->id }}, '{{ $user->name }}')">
                                <svg id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 469.404 469.404" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M310.4,235.083L459.88,85.527c12.545-12.546,12.545-32.972,0-45.671L429.433,9.409c-12.547-12.546-32.971-12.546-45.67,0 L234.282,158.967L85.642,10.327c-12.546-12.546-32.972-12.546-45.67,0L9.524,40.774c-12.546,12.546-12.546,32.972,0,45.671 l148.64,148.639L9.678,383.495c-12.546,12.546-12.546,32.971,0,45.67l30.447,30.447c12.546,12.546,32.972,12.546,45.67,0 l148.487-148.41l148.792,148.793c12.547,12.546,32.973,12.546,45.67,0l30.447-30.447c12.547-12.546,12.547-32.972,0-45.671 L310.4,235.083z"></path> </g> </g></svg>
                            </a>

                        </td>
                    </tr>
                @endforeach
            </table>
        </x-table>
        @if ($users->hasPages())
            <div class="pagination">
                <a href="{{ $users->previousPageUrl() }}" class="prev-btn {{ $users->onFirstPage() ? 'disabled' : '' }}">< previous</a>
                <span class="page-info">{{ $users->currentPage() }} | {{ $users->lastPage() }}</span>
                <a href="{{ $users->nextPageUrl() }}" class="next-btn {{ $users->hasMorePages() ? '' : 'disabled' }}">next ></a>
            </div>
        @endif

        <div class="delete-user-popup popup" style="display: none">
            <form id="deleteForm" method="POST" action="{{ route('UserManagement.deleteUser', ['id' => $user->id]) }}">
                @csrf
                @method('DELETE')
                <img src="{{asset('png/warning.jpg')}}" alt="alert image" class="popup-img-top">
                <div class="content">
                    <p class="delete-message"></p>
                    <div class="password-container">
                        <label for="password">Enter Password:</label>
                        <input id="password" name="password" type="password" placeholder="Enter password" required>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="button-container">
                    <button type="submit">Delete User</button>
                    <button type="button" onclick="hideDeleteUserModal()">Cancel</button>
                </div>
            </form>
        </div>

    </div>
</x-layout>
