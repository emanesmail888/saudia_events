<div class="container">

    <div class="panel panel-default">

       

        <div class="row mt-4 panel-heading d-flex">

            <div class="col-md-6">
                <h4 class=" px-4 text-lg font-semibold text-gray-600">
                {{ __('strings.Settings') }}
                </h4>
            </div>

            <div class="col-md-6 text-end">

            </div>
        </div>

        <div class="panel-body px-4 py-3 mb-8 bg-white rounded-lg shadow-md " >
            @if (Session::has('message'))
            <div class="alert alert-success " role="alert">{{Session::get('message')}}
            </div>

            @endif

           



            <form  enctype="multipart/form-data" wire:submit.prevent="saveSettings">
             <div class="row g-3">
                <div class="col-12">
                    <div class="form-floating">
                     <input type="email" name="email" placeholder="{{ __('strings.Email') }}" id="" class="form-control input-md" wire:model="email" >
                        @error('email')
                        <p class="text-danger">{{$message}}</p>

                        @enderror
                        <label for="email">{{ __('strings.Email') }}</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                     <input type="text" name="phone" placeholder="{{ __('strings.Phone') }}" id="" class="form-control input-md" wire:model="phone" >
                        @error('phone')
                        <p class="text-danger">{{$message}}</p>

                        @enderror
                        <label for="phone">{{ __('strings.Phone') }}</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                     <input type="text" name="phone2" placeholder="{{ __('strings.Phone2') }}" id="" class="form-control input-md" wire:model="phone2" >
                        @error('phone2')
                        <p class="text-danger">{{$message}}</p>

                        @enderror
                        <label for="phone2">{{ __('strings.Phone2') }}</label>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="form-floating">
                     <input type="text" name="address" placeholder="{{ __('strings.Address') }}" id="" class="form-control input-md" wire:model="address" >
                        @error('address')
                        <p class="text-danger">{{$message}}</p>

                        @enderror
                        <label for="address">{{ __('strings.Address') }}</label>
                    </div>
                </div>
               
                <div class="col-12">
                    <div class="form-floating">
                     <input type="text" name="map" placeholder="{{ __('strings.Map') }}" id="" class="form-control input-md" wire:model="map" >
                        @error('map')
                        <p class="text-danger">{{$message}}</p>

                        @enderror
                        <label for="map">{{ __('strings.Map') }}</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                     <input type="text" name="twitter" placeholder="{{ __('strings.Twitter') }}" id="" class="form-control input-md" wire:model="twitter" >
                        @error('twitter')
                        <p class="text-danger">{{$message}}</p>

                        @enderror
                        <label for="twitter">{{ __('strings.Twitter') }}</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                     <input type="text" name="facebook" placeholder="{{ __('strings.Facebook') }}" id="" class="form-control input-md" wire:model="facebook" >
                        @error('facebook')
                        <p class="text-danger">{{$message}}</p>

                        @enderror 
                        <label for="facebook">{{ __('strings.Facebook') }}</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                     <input type="text" name="pinterest" placeholder="{{ __('strings.Pinterest') }}" id="" class="form-control input-md" wire:model="pinterest" >
                        @error('pinterest')
                        <p class="text-danger">{{$message}}</p>

                        @enderror
                        <label for="pinterest">{{ __('strings.Pinterest') }}</label>
                    </div>
                </div>


                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" name="instagram" placeholder="{{ __('strings.Instagram') }}" id="" class="form-control input-md" wire:model="instagram" >
                            @error('instagram')
                            <p class="text-danger">{{$message}}</p>

                            @enderror
                        
                        <label for="instagram">{{ __('strings.Instagram') }}</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                     <input type="text" name="youtube" placeholder="{{ __('strings.Youtube') }}" id="" class="form-control input-md" wire:model="youtube" >
                        @error('youtube')
                        <p class="text-danger">{{$message}}</p>

                        @enderror
            
                        <label for="youtube">{{ __('strings.Youtube') }}</label>
                    </div>
                </div>

              

                

                <div class="col-12">
                    <input type="submit" value="{{ __('strings.Save') }}" class="btn btn-primary block w-100 py-3">

                </div>


             </div>
            </form>

        </div><!--panel-body  -->

    </div><!-- panel -->



</div><!-- container -->




