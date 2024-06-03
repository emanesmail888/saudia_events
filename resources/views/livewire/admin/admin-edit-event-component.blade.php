<div class="container">

    <div class="panel panel-default">

        <div class="row mt-4 panel-heading d-flex">

            <div class="col-md-6">
                <h4 class=" px-4 text-lg font-semibold text-gray-600">
                    Edit Event
                </h4>
            </div>

            <div class="col-md-6 text-end">
                <a href="{{route('admin.events')}}" class="btn btn-primary font-medium rounded-lg ml-auto text-sm mb-1  px-5 text-center  pull-right">all events</a>

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
                            <input type="text" name="event_name" placeholder="Event Name" id="" class="block mt-1 w-full form-control" wire:model="event_name" />
                                @error('event_name')
                                <p class="text-xs text-red-600 ">{{$message}}</p>

                                @enderror
                            <label for="event_name">Event Name</label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                           <input type="text" name="event_details" placeholder="Description" id="" class="block mt-1 w-full form-control" wire:model="event_details" >
                                @error('event_details')
                                <p class="text-xs text-red-600 dark:text-red-400">{{$message}}</p>

                                @enderror
                            <label for="event_details">Description</label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                           <input type="text" name="event_start_price" placeholder="Price" id="" class="block mt-1 w-full form-control" wire:model="event_start_price" >
                                @error('event_start_price')
                                <p class="text-xs text-red-600 ">{{$message}}</p>

                                @enderror
                            <label for="event_start_price">Event Start Price</label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                          <input type="text" name="duration" placeholder="duration" id="" class="block mt-1 w-full form-control" wire:model="duration" >
                                @error('duration')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                            <label for="duration">Duration</label>
                         </div>
                        </div>


                        <div class="col-12">
                         <div class="form-floating">
                          <input type="text" name="url" placeholder="url" id="" class="block mt-1 w-full form-control" wire:model="url" >
                                @error('url')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                            <label for="url">Url</label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                         <input type="text" name="conditions" placeholder="conditions" id="" class="block mt-1 w-full form-control" wire:model="conditions" >
                                @error('conditions')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                            <label for="conditions">Conditions</label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                         <input type="text" name="event_type" placeholder="event_type" id="" class="block mt-1 w-full form-control" wire:model="event_type" >
                                @error('event_type')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                            <label for="event_type">Event Type</label>
                         </div>

                       
                        <div class="col-12">
                         <div class="form-floating">
                         <input type="text" name="location" placeholder="location" id="" class="block mt-1 w-full form-control" wire:model="location" >
                                @error('location')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                            <label for="location">Location</label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                         <input type="text" name="organizedBy" placeholder="organizedBy" id="" class="block mt-1 w-full form-control" wire:model="organizedBy" >
                                @error('organizedBy')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                            <label for="organizedBy"> organizedBy</label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                         <input type="text" name="event_image" placeholder="event_image" id="" class="block mt-1 w-full form-control" wire:model="event_image" >
                            @error('event_image')
                            <p class="text-danger">{{$message}}</p>

                            @enderror

                            <label for="image"> image</label>
                         </div>
                        </div>

                        <div class="d-flex">

                            <div class="col-md-6">
                            <div class="form-floating">
                            <input type="text" name="zone_long" class="block mt-1 w-full form-control" placeholder="zone_long" wire:model="zone_long"  />
                                @error('zone_long')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                                <label for="zone_long"> zone_long</label>
                            </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-floating">
                            <input type="text" name="zone_late" class="block mt-1 w-full form-control" placeholder="zone_late" wire:model="zone_late" />
                                @error('zone_late')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                                <label for="zone_late"> zone_late</label>
                            </div>
                            </div>
                        </div>


                        <div class="d-flex">

                            <div class="col-md-6">
                            <div class="form-floating">
                            <input type="date" name="start_date" class="block mt-1 w-full form-control" placeholder="start_date" wire:model="start_date"  />
                                @error('start_date')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                                <label for="start_date"> start_date</label>
                            </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-floating">
                            <input type="date" name="end_date" class="block mt-1 w-full form-control" placeholder="end_date" wire:model="end_date" />
                                @error('end_date')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                                <label for="end_date"> end_date</label>
                            </div>
                            </div>
                        </div>    

                        <div class="d-flex">
                            <div class="col-md-6">
                            <div class="form-floating">
                            <input type="time" name="start_time" class="block mt-1 w-full form-control" placeholder="start_time" wire:model="start_time"  />
                                @error('start_time')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                                <label for="start_time"> start_time</label>
                            </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-floating">
                            <input type="time" name="end_time" class="block mt-1 w-full form-control" placeholder="end_time" wire:model="end_time" />
                                @error('end_time')
                                <p class="text-danger">{{$message}}</p>

                                @enderror

                                <label for="end_time"> end_time</label>
                            </div>
                            </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                            <select name="" id="" class="block mt-1 w-full form-control" wire:change="changeSubcategory" wire:model="category_id">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>

                                @endforeach
                            </select>
                            @error('category_id')
                            <p class="text-danger">{{$message}}</p>

                            @enderror

                            <label for="category"> category</label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                           <select name="" id="" class="block mt-1 w-full form-control" wire:model="region_id">
                            <option value="">Select Region</option>
                            @foreach ($regions as $region)
                            <option value="{{$region->id}}">{{$region->name_en}}</option>

                            @endforeach
                            </select>
                            @error('region_id')
                            <p class="text-danger">{{$message}}</p>

                            @enderror

                            <label for="region"> Region</label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                            <select name="" id="" class="block mt-1 w-full form-control" wire:change="changeSubcategory" wire:model="city_id">
                                <option value="">Select City</option>
                                @foreach ($cities as $city)
                                <option value="{{$city->id}}">{{$city->name_en}}</option>

                                @endforeach
                            </select>
                            @error('city_id')
                            <p class="text-danger">{{$message}}</p>

                            @enderror

                            <label for="city"> City</label>
                         </div>
                        </div>

                        <div class="col-12">
                         <div class="form-floating">
                           <select name="" id="" class="block mt-1 w-full form-control" wire:model="scategory_id">
                                    <option value="">Select Subcategory</option>

                                   @foreach ($scategories as $scategory)
                                    <option value="{{$scategory->id}}">{{$scategory->name}}</option>
                                   @endforeach
                            </select>
                                @error('scategory_id')
                                <p class="text-danger">{{$message}}</p>

                                @enderror


                            <label for="subcategory"> Subcategory</label>
                         </div>
                        </div>

                        <div class="col-12">
                        <input type="submit" value="Update Event" class="btn btn-primary block w-100 py-3">

                         </div>
                        </div>


                     </div>
                           
                   
                    


            </form>

        </div><!--panel-body  -->

    </div><!-- panel -->



</div><!-- container -->


