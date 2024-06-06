<div class="container">
    <div class="row mt-4 panel-heading d-flex mb-4">
          <div class="col-md-6">
              <h4 class=" px-4 text-lg font-semibold text-gray-600">
              All Plans
              </h4>
          </div>

          <div class="col-md-6 text-end">
             <a href="{{route('admin.addPlan')}}" class="btn btn-primary font-medium rounded-lg ml-auto text-sm mb-1  px-5 text-center  pull-right">add Plan</a>

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
                                    <th class="px-4 py-3">Image</th>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Description</th>
                                    <th class="px-4 py-3">Price</th>
                                    <th class="px-4 py-3">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($plans as $plan)
                                      <tr>
                                        
                                      <td>
                                          <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                              <img src="{{asset('assets/images/plans')}}/{{ $plan->image }}" alt="{{ $plan->name }}" class="rounded-circle" style="width: 32px; height: 32px;">
                                            </div>
                                           
                                          </div>
                                        </td>                                       
                                        <td>{{$plan->name}}</td>
                                        <td>{{$plan->description}}</td>
                                        <td>{{$plan->price}}</td>
                                       

                                        <td>
                                          <div class="d-flex">
                                           <a href="{{route('admin.editPlan',['plan_id'=>$plan->id])}}" class="btn btn-outline-primary btn-sm me-2"><i class=" fa fa-edit "></i></a>
                                           <a href="" class="btn btn-outline-danger btn-sm" onclick="confirm('Are You Sure, You Want to delete this Plan?')||event.stopImmediatePropagation()" wire:click.prevent="deletePlan({{$plan->id}})"><i class=" fa fa-times "></i></a>
                                            </div>
                                        </td>
                                      </tr>
                                    @endforeach
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                        <th class="px-4 py-3">Image</th>
                                        <th class="px-4 py-3">Name</th>
                                        <th class="px-4 py-3">Description</th>
                                        <th class="px-4 py-3">Price</th>
                                        <th class="px-4 py-3">Actions</th>
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

