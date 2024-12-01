<div>
<section id="categories" class="bg-white shadow-md rounded-lg p-4">
        <h2 class="text-2xl font-bold mb-4">{{ __('strings.Categories You Choose For Supscription :') }}</h2>
        <div class="row row-cols-1 row-cols-md-4 row-cols-xl-6 g-4">
          @foreach ($userCategories as $category)
            <div class="col">
              <div class="card-category bg-white shadow-xs">
                <div class="card-body d-flex bg-light align-items-center">
                 
                  <label class="text-green-100" id="category" name="category" for="category-{{ $category->id }}">@if(app()->getLocale()=='ar'){{ strip_tags(htmlspecialchars_decode($category->name_ar)) }} @else{{ strip_tags(htmlspecialchars_decode($category->name)) }}@endif</label>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <a href="{{route('user.dashboard')}}" class="btn btn-primary  d-block  mt-3 mb-3 pt-2 px-1" style="width:200px;margin-left:auto;" >{{ __('strings.update Categories') }}</a>
       

    <h2 class="text-2xl font-bold mb-4">{{ __('strings.Regions You Choose For Supscription :') }}</h2>

        <div class="row row-cols-1 row-cols-md-4 row-cols-xl-6 g-4">
          @foreach ($userRegions as $region)
            <div class="col">
              <div class="card bg-white shadow-xs">
                <div class="card-body bg-light d-flex align-items-center">
                 
                  <label class="text-green-100" id="region" name="region" for="region-{{ $region->id }}">@if(app()->getLocale()=='ar'){{ $region->name_ar }} @else{{ $region->name_en }}@endif</label>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <a href="{{route('user.dashboard')}}" class="btn btn-primary  d-block  mt-3 mb-3 pt-2 px-1" style="width:200px;margin-left:auto;" >{{ __('strings.update Regions') }}</a>



    <h2 class="text-2xl font-bold mb-4">{{ __('strings.Service You Choose For Supscription :') }}</h2>
    <div class="row row-cols-1 row-cols-md-4 row-cols-xl-6 g-4">
        @foreach ($userServices as $service)

            <div class="d-block">
                <label for="service_name">{{ __('strings.Service Name:') }}</label>
                <div class="col">
                <div class="card bg-white shadow-xs">
                    <div class="card-body bg-light d-flex align-items-center">
                    <label class="text-green-100" id="service" name="service" for="service">{{ $service->name }}</label>
                    </div>
                </div>
                </div>
            </div>
            <div class="d-block">
                <label for="service_name">{{ __('strings.Service Type:') }}</label>
                <div class="col">
                <div class="card bg-white shadow-xs">
                    <div class="card-body bg-light d-flex align-items-center">
                    <label class="text-green-100" id="service" name="service" for="service">{{ $service->service_type }}</label>
                    </div>
                </div>
                </div>
            </div>

            <div class="d-block">
                <label for="service_name">{{ __('strings.Service Method:') }}</label>
                <div class="col">
                <div class="card bg-white shadow-xs">
                    <div class="card-body bg-light d-flex align-items-center">
                    <?php  
                    $communications= json_decode($service->pivot->communication_channels?? '[]', true);
                    ?>
                    @foreach ($communications as $communication)

                        <label class="text-green-100" id="service" name="service" for="service"> {{$communication."-"}}
                        </label>
                    @endforeach
                    </div>
                </div>
              
                </div>
            </div>
        @endforeach
    </div>
    <a href="{{route('user.dashboard')}}" class="btn btn-primary  d-block  mt-3 mb-3 pt-2 px-1" style="width:200px;margin-left:auto;" >{{ __('strings.update Service Methods') }}</a>

    
    <h2 class="text-2xl font-bold mb-4">{{ __('strings.Supscription Information :') }}</h2>
    
    @if (Session::has('message'))
      <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
    @endif
    @if ($userSupscriptions != null) 
  
    <div class="row row-cols-1 row-cols-md-4 row-cols-xl-6 g-4">
            <div class="d-block">
                <label for="starts_at">{{ __('strings.Supscription Date:') }}</label>
                <div class="col">
                <div class="card bg-white shadow-xs">
                    <div class="card-body bg-light d-flex align-items-center">
                    <label class="text-green-100" id="starts_at" name="starts_at" for="starts_at">{{ $userSupscriptions->starts_at }}</label>
                    </div>
                </div>
                </div>
            </div>
            <div class="d-block">
                <label for="ends_at">{{ __('strings.Supscription Ends At:') }}</label>
                <div class="col">
                <div class="card bg-white shadow-xs">
                    <div class="card-body bg-light d-flex align-items-center">
                    <label class="text-green-100" id="ends_at" name="ends_at" for="ends_at">{{ $userSupscriptions->ends_at }}</label>
                    </div>
                </div>
                </div>
            </div>

            <div class="d-block">
                <label for="supscription_id">Subscription_id:</label>
                <div class="col">
                <div class="card bg-white shadow-xs">
                    <div class="card-body bg-light d-flex align-items-center">
                     <label class="text-green-100" id="supscription_id" name="supscription_id" for="supscription_id">{{ $userSupscriptions->payment_id }}</label>

                    </div>
                </div>
                </div>
            </div>
            <div class="d-block">
                <label for="amount">{{ __('strings.Amount:') }}</label>
                <div class="col">
                <div class="card bg-white shadow-xs">
                    <div class="card-body bg-light d-flex align-items-center">
                     <label class="text-green-100" id="amount" name="amount" for="amount">{{ $userSupscriptions->amount }}{{ $userSupscriptions->currency }}</label>

                    </div>
                </div>
                </div>
            </div>
            <div class="d-block">
                <label for="status">{{ __('strings.Status:') }}</label>
                <div class="col">
                <div class="card bg-white shadow-xs">
                    <div class="card-body bg-light d-flex align-items-center">
                     <label class="text-green-100" id="status" name="status" for="status">{{ $userSupscriptions->status }}</label>

                    </div>
                </div>
                </div>
            </div>
       
        
    </div>
    <button wire:click.prevent="cancel_supscription" class="btn btn-primary  d-block  mt-3 mb-3 pt-2 px-1" style="width:200px;margin-left:auto;">cancel Service </button>

  
    @endif
   


  </section>



</div>
