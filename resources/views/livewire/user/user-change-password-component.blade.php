<div class="row">
    <h5 class="p-5">Change Password</h5>

    <div class="col-md-6">
        <img class="wave" src="{{ asset('dist/img/wave.png') }}">

        <div class="img">
        <img src="{{ asset('dist/img/bg.svg') }}">
        </div>
    </div><!-- col-md-6" -->

    <div class="col-md-4 offset-lg-1">
            @if (Session::has('password_success'))
                <div class="alert alert-success " role="alert">{{Session::get('password_success')}}
                </div>
            @elseif (Session::has('password_error'))
                <div class="alert alert-danger " role="alert">{{Session::get('password_error')}}
                </div>

            @endif
            <div class="login-content mt-4">
                
                <form  wire:submit.prevent="changePassword">
                    <img src="{{ asset('dist/img/avatar.svg') }}" class="mb-2">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="password" name="current_password" placeholder="Current Password" id="" class="form-control block mt-1 w-full" wire:model="current_password" >
                                @error('current_password')
                                <p class="text-danger">{{$message}}</p>

                                @enderror
                            
                                <label for="password">Current Password</label>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="password" name="password" placeholder="New Password" id="" class="block mt-1 w-full form-control" wire:model="password" >
                                @error('password')
                                <p class="text-danger">{{$message}}</p>

                                @enderror 
                                <label for="password">New Password</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <input type="password" name="password_confirmation" placeholder="Confirm Password" id="" class="block mt-1 w-full form-control" wire:model="password_confirmation" >
                                @error('password_confirmation')
                                <p class="text-danger">{{$message}}</p>

                                @enderror
                                <label for="password_confirmation">Confirm Password </label>
                            </div>
                        </div>

                        
                        <div class="col-12">
                                <input type="submit" value="Change Password" class="btn btn-primary w-100 py-3">

                        </div>
                        
                        
                    
                    

                    </div>
                

                
                    
                </form>
            </div>
        
        
                


    </div><!-- col-md-4 -->
</div><!-- row -->


