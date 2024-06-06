<div class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
                <div class="container">
                    <div class="row g-2">
                        <div class="col-md-10">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <input type="text" class="form-control border-0 py-3"
                                        placeholder="Search Keyword" wire:model="search_keyword">
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select border-0 py-3" wire:model="category_id">
                                        <option selected>Event Type</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach

                                        

                                    </select>

                                </div>
                                <div class="col-md-4">
                                    <select class="form-select border-0 py-3"  wire:model="region_id">
                                        <option selected>Location</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->name_ar }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-dark border-0 w-100 py-3" wire:click="search">Search</button>
                        </div>
                    </div>
                </div>
            @if ($this->getEvents() && count($this->getEvents()) > 0)
            <div class="mt-4">
                <h2 class="text-xl font-bold mb-2">Search Results</h2>
                
                <div class="container-xxl py-5">
                <div class="container">
                <div class="row g-4">
                @foreach ($this->getEvents() as $event)
                        <div class="col-lg-4  col-md-6 wow fadeInUp " data-wow-delay="0.1s">
                            <div class="property-item bg-white rounded overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <a href="{{$event->url}}"><img class="img-fluid"
                                            src="{{$event->event_image}}" alt=""></a>
                                    <div
                                        class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">
                                        {{ $event->category->name }}</div>
                                    <div
                                        class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">
                                        {{ $event->event_type }}</div>
                                </div>
                                <div class="p-4 pb-0">
                                    <h5 class="text-info mb-3">{{ $event->event_name }}</h5>
                                    <a class="d-block h5 mb-2"
                                        href="{{ $event->url }}">{{ $event->start_date }}</a>
                                    <p><i class="fa fa-map-marker-alt text-primary me-2"></i>{{ $event->location }}
                                    </p>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2"><i
                                            class="fa fa-clock text-primary me-2"></i>{{ $event->start_time }}</small>
                                    <small class="flex-fill text-center border-end py-2"><i
                                            class="fa fa-building text-primary me-2"></i>{{ $event->organizedBy }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                   
                    </div>
                    </div>
                    </div>
                   
                </div>

                <div class="load-more-container">
                        <button wire:click="loadMore()" class="btn btn-dark d-block mx-auto py-3 px-6 ">Load More</button>
                </div>


            </div>
            @endif
</div>
