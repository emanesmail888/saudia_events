<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-0 gx-5 align-items-end">
            <div class="col-lg-6">
                <div class="text-start mx-auto mb-5 wow slideInLeft" data-wow-delay="0.1s">
                    <h1 class="mb-3">All Events</h1>
                    <p>All Events in <span class=" text-info">{{$city->name_ar}}</span>. in Saudia Arabia.</p>
                </div>
            </div>

        </div>
        <div class="row g-4">
            @foreach($events_city as $event_city)

                    <div class="col-lg-4 col-md-6 wow fadeInUp " data-wow-delay="0.1s">
                        <div class="property-item rounded overflow-hidden">
                            <div class="position-relative overflow-hidden">
                                <a href="{{$event_city->url}}"><img class="img-fluid" src="{{$event_city->event_image}}" alt=""></a>
                                <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">{{$event_city->category->name}}</div>
                                <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">{{$event_city->event_type}}</div>
                            </div>
                            <div class="p-4 pb-0">
                                <h5 class="text-primary mb-3">{{$event_city->event_name}}</h5>
                                <a class="d-block h5 mb-2" href="">{{$event_city->start_date}}</a>
                                <p><i class="fa fa-map-marker-alt text-primary me-2"></i>{{$event_city->location}}</p>
                            </div>
                            <div class="d-flex border-top">
                                <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>{{$event_city->start_time}}</small>
                                <small class="flex-fill text-center border-end py-2"><i class="fa fa-building text-primary me-2"></i>{{$event_city->organizedBy}}</small>
                            </div>
                        </div>
                    </div>




            @endforeach
            {{$events_city->links()}}
           

           
        </div>
        

        





    </div>
</div>
