<div>
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <h5> Profile</h5>

                            </div>

                        </div><!-- row -->

                    </div><!--panel-heading  -->
                    <div class="panel-body row d-flex">

                        <div class="col-md-4">
                            @if ($user->profile->image)
                            <img src="{{asset('assets/images/profile')}}/{{$user->profile->image}}" width="100%" alt="">
                            @else
                            <img src="{{asset('assets/images/profile/avatar.svg')}}" width="100%" alt="">


                            @endif

                        </div>


                        <div class="col-md-8">
                            <div class="row">
                              
                            <p><b class="col-md-3 mx-3 ">Name:</b><span class="col-md-5 pl-4">{{$user->name}}</span</p>
                            <p><b class="col-md-3 mx-3">Email:</b><span class="col-md-5 pl-4">{{$user->email}}</span></p>
                            <p><b class="col-md-3 mx-3">Mobile:</b><span class="col-md-5 pl-4">{{$user->profile->mobile}}</span</p>
                            <p><b class="col-md-4 mx-4">City :</b><span class="col-md-5 pl-4">{{$user->profile->city}}</span</p>
                            <p><b class="col-md-3 mx-3">Address:</b><span class="col-md-5 pl-4">{{$user->profile->address}}</span</p>
                            <p><b class="col-md-3 mx-3">Country:</b><span class="col-md-5 pl-4">{{$user->profile->country}}</span</p>
                            <p><b class="col-md-3 mx-3">Zipcode:</b><span class="col-md-5 pl-4">{{$user->profile->zipcode}}</span</p>

                            <div class="col-12">
                               <a href="{{route('user.editProfile')}}"  class="btn btn-primary d-block w-75 mx-auto py-2 pull-right"> update Profile</a>

                            </div>

                           </div>
                        </div>


                        


                    </div><!-- panel-body -->


                </div><!-- panel -->

            </div><!-- col-md-12 -->

        </div><!-- row -->

    </div><!-- container -->

</div>