<div class="container">

    <div class="panel panel-default">

        <div class="row mt-4 panel-heading d-flex">

            <div class="col-md-6">
                <h4 class=" px-4 text-lg font-semibold text-gray-600">
                {{ __('strings.Edit Event') }}
                </h4>
            </div>

            <div class="col-md-6 text-end">
                <a href="{{route('admin.events', ['locale' => App::getLocale()])}}" class="btn btn-primary font-medium rounded-lg ml-auto text-sm mb-1  px-5 text-center  pull-right">{{ __('strings.all events') }}</a>

            </div>
        </div>



        <div class="panel-body px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800" >
            @if (Session::has('message'))
            <div class="alert alert-success " role="alert">{{Session::get('message')}}
            </div>

            @endif



            <form  enctype="multipart/form-data" wire:submit.prevent="updateEvent">
            <div class="row g-3">
                        <div class="col-12">
                         <div class="form-floating">
                            <input type="text" name="event_name" placeholder="{{ __('strings.Event Name') }}" id="" class="block mt-1 w-full form-control" wire:model="event_name" />
                                @error('event_name')
                                <p class="text-xs text-red-600 ">{{$message}}</p>

                                @enderror
                            <label for="event_name">{{ __('strings.Event Name') }}</label>
                         </div>
                        </div>
                        <div class="col-12">

                         <div class="form-floating">
                            <input type="text" name="event_name_ar" placeholder="{{ __('strings.Event Name Arabic') }}" id="" class="block mt-1 w-full form-control" wire:model="event_name_ar" />
                                @error('event_name_ar')
                                <p class="text-xs text-red-600 ">{{$message}}</p>

                                @enderror
                            <label for="event_name">{{ __('strings.Event Name Arabic') }}</label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                           <input type="text" name="event_details" placeholder="{{ __('strings.Description') }}" id="" class="block mt-1 w-full form-control" wire:model="event_details" >
                                @error('event_details')
                                <p class="text-xs text-red-600 dark:text-red-400">{{$message}}</p>

                                @enderror
                            <label for="event_details">{{ __('strings.Description') }}</label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                           <input type="text" name="event_start_price" placeholder="{{ __('strings.Price') }}" id="" class="block mt-1 w-full form-control" wire:model="event_start_price" >
                                @error('event_start_price')
                                <p class="text-xs text-red-600 ">{{$message}}</p>

                                @enderror
                            <label for="event_start_price">{{ __('strings.Event Start Price') }}</label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                          <input type="text" name="duration" placeholder="{{ __('strings.Duration') }}" id="" class="block mt-1 w-full form-control" wire:model="duration" >
                                @error('duration')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                            <label for="duration">{{ __('strings.Duration') }}</label>
                         </div>
                        </div>


                        <div class="col-12">
                         <div class="form-floating">
                          <input type="text" name="url" placeholder="{{ __('strings.Url') }}" id="" class="block mt-1 w-full form-control" wire:model="url" >
                                @error('url')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                            <label for="url">{{ __('strings.Url') }}</label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                         <input type="text" name="conditions" placeholder="{{ __('strings.Conditions') }}" id="" class="block mt-1 w-full form-control" wire:model="conditions" >
                                @error('conditions')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                            <label for="conditions">{{ __('strings.Conditions') }}</label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                         <input type="text" name="event_type" placeholder="{{ __('strings.Event Type') }}" id="" class="block mt-1 w-full form-control" wire:model="event_type" >
                                @error('event_type')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                            <label for="event_type">{{ __('strings.Event Type') }}</label>
                         </div>

                       
                        <div class="col-12">
                         <div class="form-floating">
                         <input type="text" name="location" placeholder="{{ __('strings.Location') }}" id="" class="block mt-1 w-full form-control" wire:model="location" >
                                @error('location')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                            <label for="location">{{ __('strings.Location') }}</label>
                         </div>
                        </div>
                        
                        <div class="col-12">
                         <div class="form-floating">
                         <input type="text" name="location_ar" placeholder="{{ __('strings.Location Arabic') }}" id="" class="block mt-1 w-full form-control" wire:model="location_ar" >
                                @error('location_ar')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                            <label for="location">{{ __('strings.Location Arabic') }}</label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                         <input type="text" name="organizedBy" placeholder="{{ __('strings.organizedBy') }}" id="" class="block mt-1 w-full form-control" wire:model="organizedBy" >
                                @error('organizedBy')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                            <label for="organizedBy">{{ __('strings.organizedBy') }} </label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                         <input type="text" name="event_image" placeholder="{{ __('strings.Image') }}" id="" class="block mt-1 w-full form-control" wire:model="event_image" >
                            @error('event_image')
                            <p class="text-danger">{{$message}}</p>

                            @enderror

                            <label for="image">{{ __('strings.Image') }} </label>
                         </div>
                        </div>

                        <div class="d-flex">

                            <div class="col-md-6">
                            <div class="form-floating">
                            <input type="text" name="zone_long" class="block mt-1 w-full form-control" placeholder="{{ __('strings.zone_long') }}" wire:model="zone_long"  />
                                @error('zone_long')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                                <label for="zone_long">{{ __('strings.zone_long') }} </label>
                            </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-floating">
                            <input type="text" name="zone_late" class="block mt-1 w-full form-control" placeholder="{{ __('strings.zone_late') }}" wire:model="zone_late" />
                                @error('zone_late')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                                <label for="zone_late">{{ __('strings.zone_late') }} </label>
                            </div>
                            </div>
                        </div>


                        <div class="d-flex">

                            <div class="col-md-6">
                            <div class="form-floating">
                            <input type="date" name="start_date" class="block mt-1 w-full form-control" placeholder="{{ __('strings.start_date') }}" wire:model="start_date"  />
                                @error('start_date')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                                <label for="start_date">{{ __('strings.start_date') }} </label>
                            </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-floating">
                            <input type="date" name="end_date" class="block mt-1 w-full form-control" placeholder="{{ __('strings.end_date') }}" wire:model="end_date" />
                                @error('end_date')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                                <label for="end_date">{{ __('strings.end_date') }} </label>
                            </div>
                            </div>
                        </div>    

                        <div class="d-flex">
                            <div class="col-md-6">
                            <div class="form-floating">
                            <input type="time" name="start_time" class="block mt-1 w-full form-control" placeholder="{{ __('strings.start_time') }}" wire:model="start_time"  />
                                @error('start_time')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                                <label for="start_time">{{ __('strings.start_time') }} </label>
                            </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-floating">
                            <input type="time" name="end_time" class="block mt-1 w-full form-control" placeholder="{{ __('strings.end_time') }}" wire:model="end_time" />
                                @error('end_time')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                                <label for="end_time"> {{ __('strings.end_time') }}</label>
                            </div>
                            </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                            <select name="" id="" class="block mt-1 w-full form-control" wire:change="changeSubcategory" wire:model="category_id">
                                <option value="">{{ __('strings.Select Category') }}</option>
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}">@if(app()->getLocale()=='ar'){{$category->name_ar}}@else{{$category->name}}@endif</option>

                                @endforeach
                            </select>
                            @error('category_id')
                            <p class="text-danger">{{$message}}</p>

                            @enderror

                            <label for="category">{{ __('strings.Category') }} </label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                           <select name="" id="" class="block mt-1 w-full form-control" wire:model="region_id">
                            <option value="">{{ __('strings.Select Region') }}</option>
                            @foreach ($regions as $region)
                            <option value="{{$region->id}}">@if(app()->getLocale()=='ar'){{$region->name_ar}}@else{{$region->name_en}}@endif</option>

                            @endforeach
                            </select>
                            @error('region_id')
                            <p class="text-danger">{{$message}}</p>

                            @enderror

                            <label for="region">{{ __('strings.Region') }} </label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                            <select name="" id="" class="block mt-1 w-full form-control" wire:change="changeSubcategory" wire:model="city_id">
                                <option value="">{{ __('strings.Select City') }}</option>
                                @foreach ($cities as $city)
                                <option value="{{$city->id}}">@if(app()->getLocale()=='ar'){{$city->name_ar}}@else{{$city->name_en}}@endif</option>

                                @endforeach
                            </select>
                            @error('city_id')
                            <p class="text-danger">{{$message}}</p>

                            @enderror

                            <label for="city"> {{ __('strings.City') }}</label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                           <select name="" id="" class="block mt-1 w-full form-control" wire:model="scategory_id">
                                    <option value="">{{ __('strings.Select Subcategory') }}</option>

                                   @foreach ($scategories as $scategory)
                                    <option value="{{$scategory->id}}">{{$scategory->name}}</option>
                                   @endforeach
                            </select>
                                @error('scategory_id')
                                <p class="text-danger">{{$message}}</p>

                                @enderror


                            <label for="subcategory">{{ __('strings.Subcategory') }} </label>
                         </div>
                        </div>

                        <div class="col-12">
                        <input type="submit" value="{{ __('strings.Update Event') }}" class="btn btn-primary block w-100 py-3">

                         </div>
                        </div>


                     </div>
                           
                   
                    


            </form>

        </div><!--panel-body  -->

    </div><!-- panel -->



</div><!-- container -->


