<x-guest-layout>
        <div class="row">
            <h5 class="px-5 pt-5">Forgot Password</h5>
                <div class="mb-4 text-sm text-gray-600 text-center">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>


            <div class="col-md-6">
                <img class="wave" src="{{ asset('dist/img/wave.png') }}">

                <div class="img">
                <img src="{{ asset('dist/img/bg.svg') }}">
                </div>
            </div><!-- col-md-6" -->

            <div class="col-md-4 offset-lg-1">
                <x-jet-validation-errors class="mb-4" />
                @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                @endif
                <div class="login-content mt-4">
                    
                    <form method="POST" action="{{ route('password.email') }}">
                        <img src="{{ asset('dist/img/avatar.svg') }}" class="mb-2">
                        @csrf
                        <div class="row g-3">
                            
                            <div class="col-12">
                                <div class="form-floating">
                                    <input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" required autofocus />
                                    <label for="email">Your Email</label>
                                </div>
                            </div>

                           
                    

                            <div class="flex items-center justify-end mt-4">
                            

                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Email Password Reset Link</button>
                                </div>
                            </div>
                
                
                           
                        </div>
                    </form>
                </div>

            </div><!-- col-md-4 -->
        </div><!-- row -->
       

     
</x-guest-layout>
