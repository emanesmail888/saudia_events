            <!-- Header Start -->
            <div class="container-fluid header bg-white p-0">
                <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
                    <div class="col-md-6 p-5 mt-lg-5">
                        <h3 class="display-6 animated fadeIn mb-4">Find A <span class="text-primary">Perfect Events</span>
                            To Enjoy With Your Family</h3>
                        <p class="animated fadeIn mb-4 pb-2">Explore all the events around you, everywhere in Saudi
                            Arabia, and enjoy them with your family.</p>
                        <a href="{{route('all_events')}}" class="btn btn-primary py-3 px-5 me-3 animated fadeIn">Get Started</a>
                    </div>
                    <div class="col-md-6 animated fadeIn">
                        <div class="owl-carousel header-carousel">
                            <div class="owl-carousel-item">
                                <img class="img-fluid" style="height:600px; width:100%;"
                                    src="{{ asset('dist/img/jadda9.jpg') }}" alt="">
                            </div>
                            <div class="owl-carousel-item">
                                <img class="img-fluid" style="height:600px;" src="{{ asset('dist/img/events2.jpg') }}"
                                    alt="">
                            </div>
                            <div class="owl-carousel-item">
                                <img class="img-fluid" style="height:600px;" src="{{ asset('dist/img/events3.jpg') }}"
                                    alt="">
                            </div>
                            <div class="owl-carousel-item">
                                <img class="img-fluid" style="height:600px;" src="{{ asset('dist/img/events4.jpg') }}"
                                    alt="">
                            </div>
                            <div class="owl-carousel-item">
                                <img class="img-fluid" style="height:600px;" src="{{ asset('dist/img/events6.png') }}"
                                    alt="">
                            </div>
                            <div class="owl-carousel-item">
                                <img class="img-fluid" style="height:600px;" src="{{ asset('dist/img/about.jpg') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header End -->




            <!-- Search Start -->
            <livewire:event-search />
            <!-- Search End -->
            
            <!-- Category Start -->
            <div class="container-xxl py-5">
                <div class="container">
                    <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                        <h1 class="mb-3">Events Categories</h1>
                        <p>search all events with categories. all categories of events and conferences around saudia
                            arabia .you can choose what you need.</p>
                    </div>
                    <div class="row g-4">
                        @foreach ($categories as $category)
                            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                                <a class="cat-item d-block bg-light text-center rounded p-3" href="{{route('event.category',['category_id'=>$category->id])}}">
                                    <div class="rounded p-4">
                                        <div class="icon mb-3">
                                            <img src="{{ asset('dist/img/category.png') }}" alt="">
                                        </div>
                                        <h6>{{ strip_tags(htmlspecialchars_decode($category->name)) }}</h6>
                                    </div>
                                </a>
                            </div>
                        @endforeach



                    </div>
                </div>
            </div>
            <!-- Category End -->


            <!-- About Start -->
            <div class="container-xxl py-5">
                <div class="container">
                    <div class="row g-5 align-items-center">
                        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                            <div class="about-img position-relative overflow-hidden p-5 pe-0">
                                <img class="img-fluid w-100" src="{{ asset('dist/img/events5.jpg') }}">
                            </div>
                        </div>
                        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                            <h1 class="mb-4">Discover All Events Around Saudia Arabia.</h1>
                            <p class="mb-4">You will be in touch With All the events around you . All types of events
                                you want. All places and travels you want. You can book event you want from all site
                                provided event,Get in touch with us.</p>
                            <p><i class="fa fa-check text-primary me-3"></i>Get The Events Via Whatsapp.</p>
                            <p><i class="fa fa-check text-primary me-3"></i>Get The Events Via Mail.</p>
                            <p><i class="fa fa-check text-primary me-3"></i>Get All Conferences you Want to Attend.</p>
                            <a class="btn btn-primary py-3 px-5 mt-3" href="">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- About End -->


            <!-- City List Start -->
            <div class="container-xxl py-5">
                <div class="container">
                    <div class="row g-0 gx-5 align-items-end">
                        <div class="col-lg-6">
                            <div class="text-start mx-auto mb-5 wow slideInLeft" data-wow-delay="0.1s">
                                <h1 class="mb-3">Featured Locations.</h1>
                                <p>Popular destination around the saudia arabia. discover what you like .</p>
                            </div>
                        </div>
                        <div class="col-lg-6 text-start text-lg-end wow slideInRight" data-wow-delay="0.1s">
                            <ul class="nav nav-pills d-inline-flex justify-content-end mb-5">
                                <li class="nav-item me-2">
                                    <a class="btn btn-outline-primary active" data-bs-toggle="pill"
                                        href="#tab-1">الرياض</a>
                                </li>
                                <li class="nav-item me-2">
                                    <a class="btn btn-outline-primary" data-bs-toggle="pill"
                                        href="#tab-2">جدة</a>
                                </li>
                                <li class="nav-item me-0">
                                    <a class="btn btn-outline-primary" data-bs-toggle="pill"
                                        href="#tab-3">الدرعية</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane fade show p-0 active">
                            <div class="row g-4">
                                @foreach ($riyad_events as $riyad_event)
                                    <div class="col-lg-4 col-md-6 wow fadeInUp " data-wow-delay="0.1s">
                                        <div class="property-item rounded overflow-hidden">
                                            <div class="position-relative overflow-hidden">
                                                <a href="{{ $riyad_event->url }}"><img class="img-fluid"
                                                        src="{{ $riyad_event->event_image }}" alt=""></a>
                                                <div
                                                    class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">
                                                    {{ $riyad_event->category->name }}</div>
                                                <div
                                                    class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">
                                                    {{ $riyad_event->event_type }}</div>
                                            </div>
                                            <div class="p-4 pb-0">
                                                <h5 class="text-primary mb-3">{{ $riyad_event->event_name }}</h5>
                                                <a class="d-block h5 mb-2"
                                                    href="">{{ $riyad_event->start_date }}</a>
                                                <p><i
                                                        class="fa fa-map-marker-alt text-primary me-2"></i>{{ $riyad_event->location }}
                                                </p>
                                            </div>
                                            <div class="d-flex border-top">
                                                <small class="flex-fill text-center border-end py-2"><i
                                                        class="fa fa-clock text-primary me-2"></i>{{ $riyad_event->start_time }}</small>
                                                <small class="flex-fill text-center border-end py-2"><i
                                                        class="fa fa-building text-primary me-2"></i>{{ $riyad_event->organizedBy }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">

                                    <a class="btn btn-primary py-3 px-5"
                                        href="{{ route('events.city', ['city_id' => $riyad_city_id]) }}">Browse More Events
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane fade show p-0">
                            <div class="row g-4">

                                @foreach ($jeddah_events as $jeddah_event)
                                    <div class="col-lg-4 col-md-6 wow fadeInUp " data-wow-delay="0.1s">
                                        <div class="property-item rounded overflow-hidden">
                                            <div class="position-relative overflow-hidden">
                                                <a href="{{ $jeddah_event->url }}"><img class="img-fluid"
                                                        src="{{ $jeddah_event->event_image }}" alt=""></a>
                                                <div
                                                    class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">
                                                    {{ $jeddah_event->category->name }}</div>
                                                <div
                                                    class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">
                                                    {{ $jeddah_event->event_type }}</div>
                                            </div>
                                            <div class="p-4 pb-0">
                                                <h5 class="text-primary mb-3">{{ $jeddah_event->event_name }}</h5>
                                                <a class="d-block h5 mb-2"
                                                    href="">{{ $jeddah_event->start_date }}</a>
                                                <p><i
                                                        class="fa fa-map-marker-alt text-primary me-2"></i>{{ $jeddah_event->location }}
                                                </p>
                                            </div>
                                            <div class="d-flex border-top">
                                                <small class="flex-fill text-center border-end py-2"><i
                                                        class="fa fa-clock text-primary me-2"></i>{{ $jeddah_event->start_time }}</small>
                                                <small class="flex-fill text-center border-end py-2"><i
                                                        class="fa fa-building text-primary me-2"></i>{{ $jeddah_event->organizedBy }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">

                                    <a class="btn btn-primary py-3 px-5"
                                        href="{{ route('events.city', ['city_id' => $jaddah_city_id]) }}">Browse More
                                        Events</a>
                                </div>
                            </div>
                        </div>
                        <div id="tab-3" class="tab-pane fade show p-0">
                            <div class="row g-4">
                                @foreach ($diriah_events as $diriah_event)
                                    <div class="col-lg-4 col-md-6 wow fadeInUp " data-wow-delay="0.1s">
                                        <div class="property-item rounded overflow-hidden">
                                            <div class="position-relative overflow-hidden">
                                                <a href="{{ $diriah_event->url }}"><img class="img-fluid"
                                                        src="{{ $diriah_event->event_image }}" alt=""></a>
                                                <div
                                                    class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">
                                                    {{ $diriah_event->category->name }}</div>
                                                <div
                                                    class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">
                                                    {{ $diriah_event->event_type }}</div>
                                            </div>
                                            <div class="p-4 pb-0">
                                                <h5 class="text-primary mb-3">{{ $diriah_event->event_name }}</h5>
                                                <a class="d-block h5 mb-2"
                                                    href="">{{ $diriah_event->start_date }}</a>
                                                <p><i
                                                        class="fa fa-map-marker-alt text-primary me-2"></i>{{ $diriah_event->location }}
                                                </p>
                                            </div>
                                            <div class="d-flex border-top">
                                                <small class="flex-fill text-center border-end py-2"><i
                                                        class="fa fa-clock text-primary me-2"></i>{{ $diriah_event->start_time }}</small>
                                                <small class="flex-fill text-center border-end py-2"><i
                                                        class="fa fa-building text-primary me-2"></i>{{ $diriah_event->organizedBy }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">

                                    <a class="btn btn-primary py-3 px-5"
                                        href="{{ route('events.city', ['city_id' => $diriah_city_id]) }}">Browse More Events
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- City List End -->


            <!-- Call to Action Start -->
            <div class="container-xxl py-5">
                <div class="container">
                    <div class="bg-light rounded p-3">
                        <div class="bg-white rounded p-4" style="border: 1px dashed rgba(0, 185, 142, .3)">
                            <div class="row g-5 align-items-center">
                                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                                    <img class="img-fluid rounded w-100" src="{{asset('dist/img/subscription.jpg')}}" alt="">
                                </div>
                                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                                    <div class="mb-4">
                                        <h1 class="mb-3">Subscription In Service . </h1>
                                        <p>Subscription via mail to get all events via email. Subscription via whatsapp to get all events via whatsapp.</p>
                                    </div>
                                    <a href="" class="btn btn-primary py-3 px-2 me-2"><i class="fab fa-whatsapp me-2"></i>Whatsapp Subscription</a>
                                    <a href="" class="btn btn-dark py-3 px-2"><i class="fa fa-envelope  me-2"></i>Mail Subscription</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Call to Action End -->


            <!-- Plan Start -->
            <div class="container-xxl py-5">
                <div class="container">
                    <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s"
                        style="max-width: 600px;">
                        <h1 class="mb-3">Subscription Plans</h1>
                        <p>Choose from the available options the one you prefer. Whatsapp if you want to recieve events with whatsapp Or mail if you prefer receiving mail.</p>
                    </div>
                    <div class="row g-4">
                        @foreach ($plans as $plan)

                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="team-item rounded overflow-hidden">
                                    <div class="position-relative">
                                        <img class="img-fluid d-block mx-auto mb-5 pt-3" style="width:200px;height:200px;" src="{{asset('assets/images/plans')}}/{{$plan->image}}" alt="{{$plan->name}}">
                                        <div class="position-absolute start-50 top-100 translate-middle my-4 d-flex align-items-center">

                                            <h5 style="color:#00B98E;">{{$plan->price}} </h5>

                                        </div>
                                    </div>
                                    <div class="text-center p-4 mt-3">
                                        <h5 class="fw-bold mb-0">{{$plan->name}} subscription</h5>

                                    </div>
                                    <div class="text-center p-4 mt-3">
                                        <a class="btn btn-primary py-2 px-5"
                                        href="{{route('plan_details',['plan_id'=>$plan->id])}}">Subscription Now
                                      </a>
                                    </div>

                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
            <!-- Plan End -->


            <!-- Experiences Start -->
            <div class="container-xxl py-5">
                <div class="container">
                    <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s"
                        style="max-width: 600px;">
                        <h1 class="mb-3">Experiences Around Year</h1>
                        <p>Discover events and travels found around the year. Join online in travels and events by booking online from event site. Determine the day and time you prefer.</p>
                    </div>
                    <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                        @foreach($experiences_events as $experiences_event)
                            <div class="testimonial-item bg-light rounded p-3">
                                <div class="bg-white border rounded ">
                                    <!-- <p>{{$experiences_event->event_title}}</p> -->
                                    <div class="">
                                        <a href="{{$experiences_event->url}}"><img class="img-fluid flex-shrink-0 rounded" src="{{$experiences_event->event_image}}"
                                            style="width: 100%; height:200px; position:relative;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"></a>
                                        <div class="" style="position: absolute;top: 50%;left: 25%;transform: translate(-20%, -20%);
                                            font-weight: bold;text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
                                            <a href="{{$experiences_event->url}}" class="text-bold mb-1 text-white"><h6 class="text-bold  text-white" style="font-size: 22px;">{{$experiences_event->event_name}}</h6></a>
                                            <small>{{$experiences_event->event_start_price}}</small>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                       
                    </div>
                </div>
            </div>
            <!-- Experiences End -->
