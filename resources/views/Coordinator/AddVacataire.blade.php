<x-layout title="Add User">
    <x-slot:head>
        @vite([
            'resources/js/Coordinator/AddVacataire.js',
            'resources/css/AddUser.css',
        ])
    </x-slot:head>

    <x-nav/>

    <div class="main-container">

        @if ($errors->any())
            <div class="error-messages-holder">
                <div class="error-messages">
                    <h1>Invalid Information</h1>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form class="add-user-form" action="{{ route('Coordinator.VacataireAccount.addVacataireDB') }}" method="post">
            @csrf

            <h1>Add User Information</h1>
            <div class="name-wrapper wrapper">
                <label for="name">Full Name:</label>
                @if($errors->has('name'))
                    <p class="error-text">{{ $errors->first('name') }}</p>
                @endif
                <input type="text" id="name" name="name" required>
            </div>

            <div class="email-wrapper wrapper">
                <label for="email">Email:</label>
                @if($errors->has('email'))
                    <p class="error-text">{{ $errors->first('email') }}</p>
                @endif
                <input type="email" id="email" name="email" required>
            </div>

            <div class="phone-wrapper wrapper">
                <label for="phone">Phone:</label>
                @if($errors->has('phone'))
                    <p class="error-text">{{ $errors->first('phone') }}<span>+212-601020304</span></p>
                @endif
                <input type="text" id="phone" name="phone" required>
            </div>

            <div class="role-wrapper wrapper">
                <label for="role">Role:</label>
                <div class="role-dropdown">
                    <div class="selected">Vacataire</div>
                </div>
            </div>

            <div class="spec-wrapper wrapper" id="">
                <label for="specialization">Specialization:</label>
                <select name="specialization" id="specialization">
                    <option value="" disabled selected>Select a specialization</option>
                    @foreach($specializations as $specialization)
                        <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="btns-wrapper">
                <a class="back-btn" href="{{ asset('/Coordinator/VacataireAccount') }}">Back</a>
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>
</x-layout>
