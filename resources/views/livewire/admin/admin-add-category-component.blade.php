<div class="container">

    <div class="panel panel-default">

       

        <div class="row mt-4 panel-heading d-flex">

            <div class="col-md-6">
                <h4 class=" px-4 text-lg font-semibold text-gray-600">
                {{ __('strings.Add New Category') }} 
                </h4>
            </div>

            <div class="col-md-6 text-end">
                <a href="{{route('admin.categories', ['locale' => App::getLocale()])}}" class="btn btn-primary font-medium rounded-lg ml-auto text-sm mb-1  px-5 text-center  pull-right">{{ __('strings.all categories') }}</a>

            </div>
        </div>

        <div class="panel-body px-4 py-3 mb-8 bg-white rounded-lg shadow-md " >
            @if (Session::has('message'))
            <div class="alert alert-success " role="alert">{{Session::get('message')}}
            </div>

            @endif

           



            <form  enctype="multipart/form-data" wire:submit.prevent="storeCategory">
             <div class="row g-3">
                <div class="col-12">
                    <div class="form-floating">
                    <input type="text" name="name" placeholder="{{ __('strings.Category Name') }}" id=""  class="block mt-1 w-full form-control" wire:model="name" />
                        @error('name')
                        <p class="text-xs text-red-600">{{$message}}</p>

                        @enderror
                    <label for="name">{{ __('strings.Category Name') }}</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                    <input type="text" name="name_ar" placeholder="{{ __('strings.Category Name Arabic') }}" id=""  class="block mt-1 w-full form-control" wire:model="name_ar" />
                        @error('name_ar')
                        <p class="text-xs text-red-600">{{$message}}</p>

                        @enderror
                    <label for="name_ar">{{ __('strings.Category Name Arabic') }}</label>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating">
                        <select name="" id=""  class="block mt-1 w-full form-control" wire:model="category_id">
                            <option value="">{{ __('strings.Non') }}</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}"> @if(app()->getLocale()=='ar') {{$category->name_ar}} @else{{$category->name}}@endif</option>

                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="text-danger">{{$message}}</p>

                        @enderror
                    <label for="category_id">{{ __('strings.Parent Category Name') }}</label>
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
                    <input type="submit" value="{{ __('strings.Add Category') }}" class="btn btn-primary block w-100 py-3">

                </div>


             </div>
            </form>

        </div><!--panel-body  -->

    </div><!-- panel -->



</div><!-- container -->
