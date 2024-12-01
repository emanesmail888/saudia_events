<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-0 gx-5 align-items-end">
            <div class="col-lg-6">
                <div class="text-start mx-auto mb-5 wow slideInLeft" data-wow-delay="0.1s">
                    <h1 class="mb-3">{{ __('strings.All Events') }}</h1>
                </div>
            </div>

        </div>
        <div class="row g-4">
            @foreach($events as $event)

                    <div class="col-lg-4 col-md-6 wow fadeInUp " data-wow-delay="0.1s">
                        <div class="property-item rounded overflow-hidden">
                            <div class="position-relative overflow-hidden">
                                <a href="{{$event->url}}"><img class="img-fluid" src="{{$event->event_image}}" alt=""></a>
                                <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">@if(app()->getLocale()=='ar'){{$event->categories->name_ar}} @else{{$event->categories->name}}@endif</div>
                                <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">{{$event->event_type}}</div>
                            </div>
                            <div class="p-4 pb-0">
                                <h5 class="text-primary mb-3">@if(app()->getLocale()=='ar'){{$event->event_name_ar}} @else{{$event->event_name}}@endif</h5>
                                <a class="d-block h5 mb-2" href="">{{$event->start_date}}</a>
                                <p><i class="fa fa-map-marker-alt text-primary me-2"></i>@if(app()->getLocale()=='ar'){{$event->location_ar}} @else{{$event->location}}@endif</p>
                            </div>
                            <div class="d-flex border-top">
                                <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>{{$event->start_time}}</small>
                                <small class="flex-fill text-center border-end py-2"><i class="fa fa-building text-primary me-2"></i>{{$event->organizedBy}}</small>
                            </div>
                        </div>
                    </div>




            @endforeach
            {{$events->links()}}
           

           
        </div>
        

        





    </div>
</div>