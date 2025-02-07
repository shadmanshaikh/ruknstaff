<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="flex w-full max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Left Side: SVG Image -->
        <div class="hidden md:block w-1/2 bg-cover ml-3" style="background-image: url('{{ asset('login.svg') }}')">
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full md:w-1/2 p-8">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('ruknlogo2.png') }}" alt="Rukn Logo" class="h-16">
            </div>
            <form wire:submit.prevent="loginCheck">
                <x-card title="Login" subtitle="Enter your credentials" class="shadow-none">
                    <x-slot:menu>
                        <x-theme-toggle class="btn-sm btn-circle" />
                    </x-slot:menu>

                    <div class="space-y-4">
                        <x-input type="text" wire:model="email" placeholder="Enter your email" class="form-input mt-1 block w-full" />
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        <x-input type="password" wire:model="password" placeholder="Enter your password" class="form-input mt-1 block w-full" />
                        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <x-slot:actions>
                        <x-button label="Login" icon="o-paper-airplane" class="btn-primary w-full mt-4" type="submit" spinner="loginCheck" />
                    </x-slot:actions>
                </x-card>
            </form>

            @if($errors->any())
                <div class="mt-4">
                    <x-alert type="danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-alert>
                </div>
            @endif
        </div>
    </div>
</div>
