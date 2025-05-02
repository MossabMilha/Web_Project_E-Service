<x-layout title="profile">

    <x-slot:head>
        @vite([
            // css files
            'resources/css/profile.css',
            'resources/js/components/user-role-styling.js'

            // js files
        ])
    </x-slot:head>

    <x-nav/>

    <div class="main-container">
        <header>

        </header>
        <div class="profile-container">


            <section class="profile-card">
                <div class="profile-header">
                    <div class="profile-banner">
                        <img src="{{ asset('png/users.jpg') }}" alt="Profile Picture" class="profile-avatar">
                    </div>
                    <h2 class="profile-name">{{auth()->user()->name}}</h2>
                    <span class="role">{{ucfirst(auth()->user()->role)}}</span>
                </div>

                <div class="profile-details">
{{--                    <div class="detail-row">--}}
{{--                        <span class="detail-label">Full Name</span>--}}
{{--                        <span class="detail-value">{{auth()->user()->name}}</span>--}}
{{--                    </div>--}}

                    <div class="detail-row">
                        <span class="detail-label">Email</span>
                        <span class="detail-value">{{auth()->user()->email}}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Phone</span>
                        <span class="detail-value">{{auth()->user()->phone ?: 'N/A'}}</span>
                    </div>

                    @if(auth()->user()->role == 'professor' || auth()->user()->role == 'vacataire')
                        <div class="detail-row">
                            <span class="detail-label">Specialization</span>
                            <span class="detail-value">{{auth()->user()->speciality ?: 'N/A'}}</span>
                        </div>
                    @endif

                    <div class="detail-row">
                        <span class="detail-label">Member Since</span>
                        <span class="detail-value">{{auth()->user()->created_at->format('M d, Y')}}</span>
                    </div>
                </div>

                <div class="profile-actions">
                    @if(auth()->user()->role != 'admin')
                        <p class="contact-admin-note">To update your information, please contact an administrator.</p>
                    @endif
                </div>
            </section>
        </div>
    </div>

</x-layout>
