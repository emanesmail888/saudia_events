   <div class="container">
    <div class="row mt-4 panel-heading d-flex mb-4">
          <div class="col-md-6">
              <h4 class=" px-4 text-lg font-semibold text-gray-600">
                  All Events
            </h4>
          </div>

          <div class="col-md-6 text-end">
              <a href="{{route('admin.addEvent')}}" class="btn btn-primary font-medium rounded-lg ml-auto text-sm mb-1  px-5 text-center  pull-right">add Event</a>

          </div>

      </div>





    <div class="data-table-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="data-table-list">
                          
                            <div class="table-responsive">
                                <table id="data-table-basic" class="table table-striped">
                                    <thead>
                                    <tr>
                                      <th>Title</th>
                                      <th>Price</th>
                                      <th>Time</th>
                                      <th>Date</th>
                                      <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($events as $event)
                                      <tr>
                                        <td>
                                          <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                              <img src="{{ $event->event_image }}" alt="{{ $event->event_name }}" class="rounded-circle" style="width: 32px; height: 32px;">
                                            </div>
                                            <div>
                                              <p class="mb-0 fw-semibold">{{ $event->event_name }}</p>
                                              <p class="mb-0 text-muted">{{ $event->region ? $event->region['name_en'] : 'Saudi Arabia' }} {{ $event->city ? '-' . $event->city['name_en'] : '' }}</p>
                                            </div>
                                          </div>
                                        </td>
                                        <td>{{ $event->event_start_price }}</td>
                                        <td>
                                          <span class="badge bg-success text-white">{{ $event->start_time }}</span>
                                        </td>
                                        <td>{{ $event->start_date }}</td>
                                        <td>
                                          <div class="d-flex">
                                            <a href="{{ route('admin.editEvent', ['event_id' => $event->id]) }}" class="btn btn-outline-primary btn-sm me-2"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-outline-danger btn-sm" onclick="confirm('Are You Sure, You Want to delete this Event?') || event.stopImmediatePropagation()" wire:click.prevent="deleteEvent({{ $event->id }})"><i class="fa fa-times"></i></a>
                                          </div>
                                        </td>
                                      </tr>
                                    @endforeach
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                          <th>Title</th>
                                          <th>Price</th>
                                          <th>Time</th>
                                          <th>Date</th>
                                          <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   

  </div>



