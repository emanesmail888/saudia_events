<div class="container-xxl py-5">
                <div class="container">
                    <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s"
                        style="max-width: 600px;">
                        <h1 class="mb-3">Subscription In {{$service->name}} service</h1>
                        <p>Choose from the available options the one you prefer. Whatsapp if you want to recieve events with whatsapp Or mail if you prefer receiving mail with premuim subscribtion.</p>
                    </div>
                    <div class="row g-4">

                            <div class="col-lg-10 col-md-10  offset-1 d-md-flex wow fadeInUp" data-wow-delay="0.1s">
                                <div class="team-item rounded overflow-hidden col-md-5 col-sm-12 ">
                                    <div class="position-relative">
                                        <img class="img-fluid d-block mx-auto mb-5 pt-3" style="width:200px;height:200px;" src="{{asset('assets/images/services')}}/{{$service->image}}" alt="{{$service->name}}">
                                        <div class="position-absolute start-50 top-100 translate-middle my-4 d-flex align-items-center">

                                            <h5 style="color:#00B98E;">{{$service->price}} </h5>

                                        </div>
                                    </div>
                                    <div class="text-center p-4 mt-3">
                                        <h5 class="fw-bold mb-0">{{$service->name}} subscription</h5>

                                    </div>
                                    @if($service->service_type == "free")
                                        <div class="text-center p-4 mt-3">
                                        <a class="btn btn-primary py-2 px-5"
                                        href="{{route('user.dashboard')}}" >Subscription Now
                                      </a>

                                    </div>
                                    @else
                                    <div class="text-center p-4 mt-3">
                                        <a class="btn btn-primary py-2 px-5"
                                        href="#" wire:click.prevent="subscribe">Subscription Now
                                      </a>

                                    </div>
                                    @endif

                                </div>
                                <div class="team-item rounded overflow-hidden col-md-5 col-sm-12">
                                    <h5 style="color:#00B98E;" class="text-center p-4">Service Featured </h5>
                                    <div class="p-4 mt-3 mb-0 pb-0">
                                            <h5 class="fw-bold mb-0 ml-3 lh-sm">

                                            <?php
                                                $lines = explode("<br>", $service->details);
                                                foreach ($lines as $line) {
                                                ?>
                                                <div class="row d-flex me-2" >
                                                <?php echo "<br>" ;?>

                                                    <div class="col-2">
                                                     <i class="fa fa-check" style="font-size:25px;padding:13px 15px;" ></i>
                                                     </div>

                                                    <div class="col-10" >
                                                     <p style="line-height:35px;">{{$line}}</p>
                                                    </div>


                                               </div>
                                                <?php
                                                }
                                             ?>
                                            </h5>

                                    </div>

                                </div>
                               
                                
                            </div>


                    </div>
                </div>
