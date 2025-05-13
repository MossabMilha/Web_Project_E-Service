<x-layout title="Vacataire Account">

    <x-slot:head>
        @vite([
        'resources/js/vacataire-account.js',
        'resources/css/Coordinator/vacataire-account.css',
        'resources/js/components/user-role-styling.js',
        'resources/css/components/popup.css',
        'resources/js/components/popup.js',
        ])
    </x-slot:head>

    <x-nav/>

<body>
    <div class="main-container">
        <div class="buttons-container">
            <div class="add-user-container">
                <form class="add-user-form" method="GET" action="{{ route('VacataireAccount.addVacataire') }}">
                    <button class="add-btn" type="submit">Add New User</button>
                </form>
            </div>
            <div class="export-users-container">
                <form method="GET" action="{{ route('export.users') }}">
                    <input type="hidden" name="role" value="Vacataire">
                    <button type="submit">Export All Vacataire Users</button>
                </form>
            </div>
        </div>
        <x-table class="table-container">
            <table>
                <tr>
                    <th><div class="th-wrapper">User Id</div></th>
                    <th><div class="th-wrapper">Full Name</div></th>
                    <th><div class="th-wrapper">Email</div></th>
                    <th><div class="th-wrapper">Role</div></th>
                    <th><div class="th-wrapper">Specialisation</div></th>
                    <th><div class="th-wrapper">Account Created At</div></th>
                    <th><div class="th-wrapper">Last Updated</div></th>
                    <th><div class="th-wrapper">Actions</div></th>
                </tr>
                @foreach($users as $user)
                    <tr>
                        <td><div class="td-wrapper"> {{ $user->id }} </div></td>
                        <td><div class="td-wrapper"> {{ $user->name }}</div></td>
                        <td><div class="td-wrapper"> {{ $user->email }}</div></td>
                        <td><div class="td-wrapper"><div class="role">{{$user->role}}</div></div></td>
                        <td>
                            <div class="td-wrapper">
                                @if(\App\Models\Specialization::find($user->specialization) == null)
                                    N/A
                                @else
                                    {{\App\Models\Specialization::find($user->specialization)->name}}
                                @endif
                            </div>
                        </td>
                        <td><div class="td-wrapper"> {{ $user->created_at }}</div></td>
                        <td><div class="td-wrapper"> {{ $user->updated_at }}</div></td>
                        <td>
                            <div class="td-wrapper">
{{--                                <a href="{{ route('VacataireAccount.user',['id' => $user->id]) }}">--}}

{{--                                </a>--}}
{{--                                <button onclick="document.getElementById('delete-user').style.display='block'; document.getElementById('user_id').value = {{$user->id}};">--}}
{{--                                    <x-svg-icon src="svg/delete-profile-icon.svg" width="1.75em" fill="var(--color-danger)" />--}}
{{--                                </button>--}}
                                <button type="button" class="open-popup-btn">
                                    <x-svg-icon src="svg/delete-profile-icon.svg" width="1.75em" fill="var(--color-danger)" />
                                </button>
                                <a href="{{ route('export.users', ['id' => $user->id]) }}">
                                    <x-svg-icon src="svg/export-2-icon.svg" width="1.75em" stroke="var(--color-success)" />
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
{{--            <form id="delete-user" method="POST" action="{{ route('VacataireAccount.deleteVacataire') }}">--}}
{{--                @csrf--}}
{{--                @method('DELETE')--}}
{{--                <h3>Enter your password to confirm deletion:</h3>--}}
{{--                <label>Password : </label><input type="password" name="password" placeholder="Password" required><br>--}}
{{--                <input type="hidden" name="user_id" id="user_id" value="">--}}
{{--                <button type="submit">Confirm Delete</button>--}}
{{--            </form>--}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </x-table>

        <x-popup>
            <form id="deleteAssignmentForm" method="POST" action="{{ route('VacataireAccount.deleteVacataire') }}">
                @csrf
                @method('DELETE')
                <img src="{{asset('png/warning.jpg')}}" alt="alert image" class="popup-img-top">
                <div class="content">
                    <p class="delete-message">Enter your password to confirm deletion:</p>
                    <div class="password-container">
                        <label for="assignment-password">Password :</label>
                        <input type="password" name="password" id="assignment-password" placeholder="Password" required>
                    </div>
                    <input type="hidden" name="user_id" id="user_id" value="">
                </div>
                <div class="button-container">
                    <button type="submit">Delete Assignment</button>
                    <button class="close-popup-btn" type="button">Cancel</button>
                </div>
            </form>
        </x-popup>

    </div>
</body>
</x-layout>
