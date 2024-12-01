<div class="container">

    <div class="panel panel-default">

       

        <div class="row mt-4 panel-heading d-flex">

            <div class="col-md-6">
                <h4 class=" px-4 text-lg font-semibold text-gray-600">
                {{ __('strings.Add New Service') }}
                </h4>
            </div>

            <div class="col-md-6 text-end">
                <a href="{{route('admin.services', ['locale' => App::getLocale()])}}" class="btn btn-primary font-medium rounded-lg ml-auto text-sm mb-1  px-5 text-center  pull-right">{{ __('strings.all services') }}</a>

            </div>
        </div>

        <div class="panel-body px-4 py-3 mb-8 bg-white rounded-lg shadow-md " >
            @if (Session::has('message'))
            <div class="alert alert-success " role="alert">{{Session::get('message')}}
            </div>

            @endif

           



            <form  enctype="multipart/form-data" wire:submit.prevent="storeService">
             <div class="row g-3">
                <div class="col-12  col-md-12">
                    <div class="form-floating">
                        <input type="text" name="name" placeholder="{{ __('strings.Service Name') }}" id="" class="block mt-1 w-full form-control"  wire:model="name" />
                            @error('name')
                            <p class="text-xs text-red-600 ">{{$message}}</p>
                            @enderror
                        
                        <label for="name">{{ __('strings.Service Name') }}</label>
                    </div>
                </div>
                <div class="col-12  col-md-12">
                    <div class="form-floating">
                        <input type="text" name="details" placeholder="{{ __('strings.Service Details') }}" id="" class="block mt-1 w-full form-control"  wire:model="details" />
                            @error('details')
                            <p class="text-xs text-red-600 ">{{$message}}</p>
                            @enderror
                        
                        <label for="details">{{ __('strings.Service Details') }}</label>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating">
                        <select name="service_type" id="" class="form-control" wire:model="service_type">
                                    <option value="free">{{ __('strings.Free') }}</option>
                                    <option value="premium">{{ __('strings.Premium') }}</option>
                                </select>
                            @error('service_type')
                            <p class="text-xs text-red-600 ">{{$message}}</p>

                            @enderror
                        
                        <label for="service_type">{{ __('strings.Service Type') }}</label>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="form-floating">
                    <input type="text" name="price" placeholder="{{ __('strings.Service Price') }}" id="" class="block mt-1 w-full form-control" wire:model="price" />
                        @error('price')
                        <p class="text-xs text-red-600 ">{{$message}}</p>

                        @enderror
                        
                        <label for="price">{{ __('strings.Price') }}</label>
                    </div>
                </div>

              

                <div class="col-12">
                    <div class="form-floating">
                        <input type="file" name="image" id="" class="block mt-1 w-full form-control" wire:model="image">

                        @error('image')
                        <p class="text-danger">{{$message}}</p>

                        @enderror
                    <label for="image"> {{ __('strings.Image') }}</label>
                    </div>
                </div>

                <div class="col-12">
                    <input type="submit" value="{{ __('strings.Add Service') }}" class="btn btn-primary block w-100 py-3">

                </div>


             </div>
            </form>

        </div><!--panel-body  -->

    </div><!-- panel -->



</div><!-- container -->

