<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information, email address, and phone number.") }}
        </p>
    </header>

    {{-- ฟอร์มส่งอีเมลยืนยัน --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- ฟอร์มอัปเดตข้อมูลผู้ใช้ --}}
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required
                autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button
                            form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- ✅ Phone --}}
        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input
                id="phone"
                name="phone"
                type="text"
                class="mt-1 block w-full"
                :value="old('phone', $user->phone)"
                autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        {{-- ✅ Gender --}}
        <div>
            <x-input-label :value="__('Gender')" />

            <div class="mt-2 flex items-center space-x-6">
                <label class="flex items-center">
                    <input type="radio" name="gender" value="male"
                        {{ old('gender', $user->gender) === 'male' ? 'checked' : '' }}
                        class="text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-700" />
                    <span class="ml-2 text-gray-700 dark:text-gray-300">Male</span>
                </label>

                <label class="flex items-center">
                    <input type="radio" name="gender" value="female"
                        {{ old('gender', $user->gender) === 'female' ? 'checked' : '' }}
                        class="text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-700" />
                    <span class="ml-2 text-gray-700 dark:text-gray-300">Female</span>
                </label>

                <label class="flex items-center">
                    <input type="radio" name="gender" value="others"
                        {{ old('gender', $user->gender) === 'others' ? 'checked' : '' }}
                        class="text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-700" />
                    <span class="ml-2 text-gray-700 dark:text-gray-300">Others</span>
                </label>
            </div>

            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        {{-- ✅ Birthdate --}}
        <div>
            <x-input-label for="birthdate" :value="__('Birthdate')" />
            <x-text-input
                id="birthdate"
                name="birthdate"
                type="date"
                class="mt-1 block w-full"
                :value="old('birthdate', $user->birthdate ? $user->birthdate->format('Y-m-d') : '')"
                autocomplete="bday" />
            <x-input-error class="mt-2" :messages="$errors->get('birthdate')" />
        </div>


        {{-- ปุ่ม Save --}}
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
