<x-guest-layout>
        <div class="row">
            <h5 class="px-5 pt-5">Reset Your Password</h5>
                

            <div class="col-md-6">
                <img class="wave" src="{{ asset('dist/img/wave.png') }}">

                <div class="img">
                <img src="{{ asset('dist/img/bg.svg') }}">
                </div>
            </div><!-- col-md-6" -->

            <div class="col-md-4 offset-lg-1">
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif
                <x-jet-validation-errors class="mb-4" />
               
                <div class="login-content mt-4">
                    
                <form method="POST" action="{{ route('password.update') }}">
                  @csrf
                  <input type="hidden" name="token" value="{{ $request->route('token') }}">
                  <img src="{{ asset('dist/img/avatar.svg') }}" class="mb-2">
                  
                        <div class="row g-3">
                            
                            <div class="col-12">
                                <div class="form-floating">
                                    <input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email', $request->email)" required autofocus />
                                    <label for="email">Email</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <input id="password" class="block mt-1 w-full form-control" placeholder="New Password" type="password" name="password" required autocomplete="new-password" />
                                    <label for="password">Password</label>
                                </div>
                           </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input id="password_confirmation" class="block mt-1 w-full form-control" type="password" name="password_confirmation" required autocomplete="new-password" />

                                    <label for="password">Confirm Password </label>
                                </div>
                           </div>

                           
                    

                            <div class="flex items-center justify-end mt-4">
                            

                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Reset Password</button>
                                </div>
                            </div>
                
                
                           
                        </div>
                    </form>
                </div>

            </div><!-- col-md-4 -->
        </div><!-- row -->
       

     
</x-guest-layout>
