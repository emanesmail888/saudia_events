<x-guest-layout>
        <div class="row">
            <h5 class="p-5">Register!!!!</h5>

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
                    <form method="POST" action="{{ route('register') }}">
                     <img src="{{ asset('dist/img/avatar.svg') }}" class="mb-2">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                <input id="name" class="block mt-1 w-full form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                    <label for="password">Name</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                <input id="password" class="block mt-1 w-full form-control" type="password" name="password" required autocomplete="new-password" />
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                <input id="password_confirmation" class="block mt-1 w-full form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                                    <label for="password">Confirm Password</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" required autofocus />
                                    <label for="email">Your Email</label>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-floating">
                                    <select class="form-control block mt-1 py-1 w-full" id="country_code" name="country_code">
                                    <option value="+966">+966 (Saudi Arabia)</option>
                                    <option value="+20">+20 (Egypt)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-floating">
                                <input id="phone" class="block mt-1 w-full form-control" type="text" name="phone"   required />
                                <label for="phone">Phone</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <select id="region_id" name="region_id" class="block mt-1 w-full form-control py-1">
                                        <option value="">Select a region</option>
                                            @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->name_ar }}</option>
                                            @endforeach
                                    </select>

                                </div>
                            </div>
                       

                        </div>
                    
                           

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div class="mt-4">
                                <x-jet-label for="terms">
                                    <div class="flex items-center">
                                        <x-jet-checkbox name="terms" id="terms"/>

                                        <div class="ml-2">
                                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                            ]) !!}
                                        </div>
                                    </div>
                                </x-jet-label>
                            </div>
                        @endif

                        <div class="flex items-center justify-end mt-4">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>
  
                        </div>
                    
                        <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Register </button>
                        </div>
                       
                    </form>
                </div>
                
                
                           
           

            </div><!-- col-md-4 -->
        </div><!-- row -->
       

     
</x-guest-layout>
