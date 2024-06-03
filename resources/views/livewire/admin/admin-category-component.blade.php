<div class="container">
    <div class="row mt-4 panel-heading d-flex mb-4">
          <div class="col-md-6">
              <h4 class=" px-4 text-lg font-semibold text-gray-600">
                 All Categories
              </h4>
          </div>

          <div class="col-md-6 text-end">
             <a href="{{route('admin.addCategory')}}" class="btn btn-primary font-medium rounded-lg ml-auto text-sm mb-1  px-5 text-center  pull-right">add Category</a>

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
                                    <th class="px-4 py-3">Id</th>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">subcategory_Name</th>
                                    <th class="px-4 py-3">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($categories as $category)
                                      <tr>
                                        
                                        <td> {{$category->id}}</td>
                                       
                                        <td>{{$category->name}}</td>
                                        <td> 
                                            <ul class="sclist">
                                                @foreach ($category->subCategories as $scategory)
                                                <li><i class="fa fa-caret-right"></i> {{$scategory->name}}
                                                    <a href="{{route('admin.editCategory',['category_id'=>$category->id,'scategory_id'=>$scategory->id])}}"><i class="fa fa-edit"></i></a>
                                                    <a href="" onclick="confirm('Are You Sure, You Want to delete this subCategory?')||event.stopImmediatePropagation()" wire:click.prevent="deleteSubcategory({{$scategory->id}})"><i class=" fa fa-times "></i></a>

                                                </li>

                                                @endforeach
                                            </ul>
                                        </td>

                                        <td>
                                          <div class="d-flex">
                                            <a href="{{route('admin.editCategory',['category_id'=>$category->id])}}" class="btn btn-outline-primary me-2 "><i class=" fa fa-edit "></i></a>
                                            <a href="" class=" btn btn-outline-danger btn-sm " onclick="confirm('Are You Sure, You Want to delete this Category?')||category.stopImmediatePropagation()" wire:click.prevent="deleteCategory({{$category->id}})"><i class=" fa fa-times fa-2x"></i></a>
                                          </div>
                                        </td>
                                      </tr>
                                    @endforeach
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                         <th class="px-4 py-3">Id</th>
                                         <th class="px-4 py-3">Name</th>
                                         <th class="px-4 py-3">subcategory_Name</th>
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





