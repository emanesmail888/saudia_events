<div class="container">

    <div class="panel panel-default">

       

        <div class="row mt-4 panel-heading d-flex">

            <div class="col-md-6">
                <h4 class=" px-4 text-lg font-semibold text-gray-600">
                   Edit Plan
                </h4>
            </div>

            <div class="col-md-6 text-end">
                <a href="{{route('admin.plans')}}" class="btn btn-primary font-medium rounded-lg ml-auto text-sm mb-1  px-5 text-center  pull-right">all plans</a>

            </div>
        </div>

        <div class="panel-body px-4 py-3 mb-8 bg-white rounded-lg shadow-md " >
            @if (Session::has('message'))
            <div class="alert alert-success " role="alert">{{Session::get('message')}}
            </div>

            @endif

           



            <form  enctype="multipart/form-data" wire:submit.prevent="updatePlan">
             <div class="row g-3">
                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" name="name" placeholder="Role Name" id="" class="block mt-1 w-full form-control"  wire:model="name" />
                            @error('name')
                            <p class="text-xs text-red-600 ">{{$message}}</p>
                            @enderror
                        
                        <label for="name">Plan Name</label>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" name="description" placeholder="Role Description" id="" class="block mt-1 w-full form-control" wire:model="description" />
                            @error('description')
                            <p class="text-xs text-red-600 ">{{$message}}</p>

                            @enderror
                        
                        <label for="email">Description</label>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="form-floating">
                    <input type="text" name="price" placeholder="Role Price" id="" class="block mt-1 w-full form-control" wire:model="price" />
                        @error('price')
                        <p class="text-xs text-red-600 ">{{$message}}</p>

                        @enderror
                        
                        <label for="email">Price</label>
                    </div>
                </div>

              

                <div class="col-12">
                    <div class="form-floating">
                        <input type="file" name="image" id="" class="block mt-1 w-full form-control" wire:model="newImage">

                        @error('image')
                         <p class="text-danger">{{$message}}</p>

                        @enderror
                        @if ($newImage)
                         <img src="{{$newImage->temporaryUrl()}}" alt="">
                        @else
                         <img src="{{asset('assets/images/plans')}}/{{$image}}" class="w-25 h-25" alt="">

                        @endif
                    <label for="image"> Image</label>
                    </div>
                </div>

                <div class="col-12">
                    <input type="submit" value="Update Plan" class="btn btn-primary block w-100 py-3">

                </div>


             </div>
            </form>

        </div><!--panel-body  -->

    </div><!-- panel -->



</div><!-- container -->



