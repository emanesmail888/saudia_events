<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading mb-2">
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5>Edit Profile</h5>

                            </div>

                        </div><!-- row -->

                    </div><!--panel-heading  -->
                    <div class="panel-body row d-flex">
                        <div class="col-md-4">

                                @if ($newImage)
                                <img src="{{$newImage->temporaryUrl()}}" style="width:300px; height:300px;" alt="">
                                @elseif($user->profile->image)
                                <img src="{{asset('assets/images/profile')}}/{{$user->profile->image}}" style="width:300px; height:300px;" alt="">
                                @else
                                <img src="{{asset('assets/images/profile/avatar.svg')}}" style="width:300px; height:300px;" alt="">
                                @endif

                        </div>


                        


                        <div class="col-md-8">
                            @if (Session::has('message'))
                            <div class="alert alert-success " role="alert">{{Session::get('message')}}
                            </div>

                            @endif
                            <form class="form-horizontal" enctype="multipart/form-data" wire:submit.prevent="updateProfile">
                             <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="file" name="image" id="" class="block mt-1 w-full form-control"  wire:model="newImage">
                                            <label for="name">profile image</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" name="name" placeholder="Name" id="" class="block mt-1 w-full form-control" wire:model="name" >
                                            <label for="name">Name</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" name="" id="" class="block mt-1 w-full form-control " disabled  value="{{$user->email}}" >
                                            <label for="name">Email</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating">
                                        <input type="text" name="mobile" placeholder="mobile" id="" class="block mt-1 w-full form-control" wire:model="mobile" >
                                            <label for="name">Mobile</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating">
                                        <input type="text" name="city" placeholder="city" id="" class="block mt-1 w-full form-control" wire:model="city" >
                                            <label for="name">City</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating">
                                          <input type="text" name="address" placeholder="address" id="" class="block mt-1 w-full form-control" wire:model="address" >
                                          <label for="name">Address</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating">
                                          <input type="text" name="country" placeholder="country" id="" class="block mt-1 w-full form-control" wire:model="country" >
                                          <label for="name">Country</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                        <input type="text" name="zipcode" placeholder="zipcode" id="" class="block mt-1 w-full form-control" wire:model="zipcode" >
                                          <label for="name">Zipcode</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <input type="submit" value="Update " class="btn btn-primary block w-100 py-3 pull-right">

                                    </div>
                                </div>


                            </form>


                        </div>
                    </div><!-- panel-body -->


                </div><!-- panel -->

            </div><!-- col-md-12 -->

        </div><!-- row -->

    </div><!-- container -->

</div>

