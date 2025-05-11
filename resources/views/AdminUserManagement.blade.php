<x-layout title="User Management">
    <x-slot:head>
        @vite([
            // css files
            'resources/css/AdminUserManagement.css',
            'resources/css/components/popup.css',
            // js files
            'resources/js/components/user-role-styling.js',
            'resources/js/AdminUserManagement.js',
            'resources/js/components/popup.js',
        ])
    </x-slot:head>

    <x-nav/>

    {{--  body  --}}
    <div class="main-container">

        <div class="search-wrapper">
            <form class="search-form" method="GET" action="{{route('UserManagement.search')}}">
                <div class="search-bar">
                    <input type="text" id="search" name="search" placeholder="Search">
                    <button class="submit-btn" type="submit"><img src="{{ asset('svg/search-icon.svg') }}" alt="Search Icon"></button>
                </div>
                <div class="dropdown">
                    <button type="button" id="OptionButton">Select an Option</button>
                    <div class="dropdown-content">
                        <a onclick="selectOption('id'); return false;">id</a>
                        <a onclick="selectOption('full name'); return false;">full name</a>
                        <a onclick="selectOption('email'); return false;">email</a>
                        <a onclick="selectOption('role'); return false;">role</a>
                        <a onclick="selectOption('specialization'); return false;">specialization</a>
                    </div>
                </div>
                <input type="hidden" id="selectedOption" name="option" value="{{ request('option', 'id') }}">
            </form>
            <form class="add-user-form" method="GET" action="{{ route('UserManagement.adduser') }}">
                <button class="add-btn" type="submit">+ Add New User</button>
            </form>
        </div>

        <div class="desktop">
            <x-table>
                <table>
                    <tr>
                        <th>
                            <div class="th-wrapper">User Id</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Full Name</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Email</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Role</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Specialisation</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Created At</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Updated At</div>
                        </th>
                        <th>
                            <div class="th-wrapper">Actions</div>
                        </th>
                    </tr>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="td-wrapper"> {{ $user->id }}</div>
                            </td>
                            <td>
                                <div class="td-wrapper"> {{ $user->name }}</div>
                            </td>
                            <td>
                                <div class="td-wrapper"> {{ $user->email }}</div>
                            </td>
                            <td>
                                <div class="td-wrapper">
                                    <div class="role">{{$user->role}}</div>
                                </div>
                            </td>
                            <td>
                                <div class="td-wrapper">
                                    @if($user->specialization == null)
                                        N/A
                                    @else
                                        {{ $user->specialization }}
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="td-wrapper"
                                     style="text-wrap: nowrap"> {{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d H:i') }}</div>
                            </td>
                            <td>
                                <div class="td-wrapper"
                                     style="text-wrap: nowrap"> {{ \Carbon\Carbon::parse($user->updated_at)->format('Y-m-d H:i') }}</div>
                            </td>
                            <td>
                                <div class="td-wrapper">
                                    <div class="icons-wrapper flex">
                                        <a href="{{ route('UserManagement.user', $user->id) }}">
                                            <x-svg-icon src="svg/edit-profile-icon.svg" width="32px" stroke="none"
                                                        fill="var(--color-tertiary)"/>
                                        </a>
                                        <button type="button"
                                                onclick="showDeleteUserSection({{ $user->id }}, '{{ $user->name }}')"
                                                class="open-popup-btn">
                                            <x-svg-icon src="svg/delete-profile-icon.svg" fill="var(--color-danger)"/>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </x-table>
        </div>
        <div class="mobile">
            <div class="users-grid">
                @foreach($users as $user)
                    <div class="user-card">
                        <div class="card-header">
                            <div class="user-id">#{{ $user->id }}</div>
                            <div class="user-role">
                                <div class="role">{{$user->role}}</div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="info-row">
                                <span class="label">Name:</span>
                                <span class="value">{{ $user->name }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">Email:</span>
                                <span class="value">{{ $user->email }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">Specialisation:</span>
                                <span class="value">
                                    @if($user->specialization == null)
                                        N/A
                                    @else
                                        {{ $user->specialization }}
                                    @endif
                    </span>
                            </div>

                            <div class="info-row">
                                <span class="label">Created:</span>
                                <span class="value">{{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d H:i') }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">Updated:</span>
                                <span class="value">{{ \Carbon\Carbon::parse($user->updated_at)->format('Y-m-d H:i') }}</span>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="icons-wrapper flex">
                                <a href="{{ route('UserManagement.user', $user->id) }}">
                                    <x-svg-icon src="svg/edit-profile-icon.svg" width="32px" stroke="none"
                                                fill="var(--color-tertiary)"/>
                                </a>
                                <button type="button"
                                        onclick="showDeleteUserSection({{ $user->id }}, '{{ $user->name }}')"
                                        class="open-popup-btn">
                                    <x-svg-icon src="svg/delete-profile-icon.svg" fill="var(--color-danger)"/>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @if ($users->hasPages())
            <div class="pagination">
                <a href="{{ $users->previousPageUrl() }}" class="prev-btn {{ $users->onFirstPage() ? 'disabled' : '' }}">< prev</a>
                <span class="page-info">{{ $users->currentPage() }} | {{ $users->lastPage() }}</span>
                <a href="{{ $users->nextPageUrl() }}" class="next-btn {{ $users->hasMorePages() ? '' : 'disabled' }}">next ></a>
            </div>
        @endif


        <x-popup>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <img src="{{asset('png/warning.jpg')}}" alt="alert image" class="popup-img-top">
                <div class="content">
                    <p class="delete-message"></p>
                    <div class="password-container">
                        <label for="password">Enter Password:</label>
                        <input id="password" name="password" type="password" placeholder="Password" required>
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
                    <button class="close-popup-btn" type="button">Cancel</button>
                </div>
            </form>
        </x-popup>

    </div>
</x-layout>
