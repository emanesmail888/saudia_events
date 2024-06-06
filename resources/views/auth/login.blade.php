<x-guest-layout>
        <div class="row">
            <h5 class="p-5">Login!!!!</h5>

            <div class="col-md-6">
                <img class="wave" src="{{ asset('dist/img/wave.png') }}">

                <div class="img">
                <img src="{{ asset('dist/img/bg.svg') }}">
                </div>
            </div><!-- col-md-6" -->

            <div class="col-md-4 offset-lg-1">
                <x-jet-validation-errors class="mb-4" />
                <div class="login-content mt-4">
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        <img src="{{ asset('dist/img/avatar.svg') }}" class="mb-2">
                        @csrf
                        <div class="row g-3">
                            
                            <div class="col-12">
                                <div class="form-floating">
                                    <input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" required autofocus />
                                    <label for="email">Your Email</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                <input id="password" class="block mt-1 w-full form-control" type="password" name="password" required autocomplete="current-password" />
                                    <label for="password">Password</label>
                                </div>
                            </div>
                    
                            <div class="block mt-4">
                                <label for="remember_me" class="flex items-center">
                                    <x-jet-checkbox id="remember_me" name="remember" />
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                </label>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                @if (Route::has('password.request'))
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif

                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Log In</button>
                                </div>
                            </div>
                
                
                           
                        </div>
                    </form>
                </div>

            </div><!-- col-md-4 -->
        </div><!-- row -->
       

     
</x-guest-layout>
