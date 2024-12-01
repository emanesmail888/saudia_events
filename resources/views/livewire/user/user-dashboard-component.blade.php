<div class="container">
    <section class="row justify-content-center mb-4">
      <div class="col-auto d-flex align-items-center">
        <div class="d-flex align-items-center step-indicator step1-active">
          <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 3rem; height: 3rem;">1</div>
        </div>
        <div style="width: 7rem; height: 5px; background-color: #d3ced1"></div>
        <div class="d-flex align-items-center step-indicator">
          <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 3rem; height: 3rem;">2</div>
        </div>
        <div style="width: 7rem; height: 5px; background-color: #d3ced1"></div>
        <div class="d-flex align-items-center step-indicator">
          <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 3rem; height: 3rem;">3</div>
        </div>
        <div style="width: 7rem; height: 5px; background-color: #d3ced1"></div>
        <div class="d-flex align-items-center step-indicator">
          <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 3rem; height: 3rem;">4</div>
        </div>
       
      </div>
    </section>

    @if (Session::has('message'))
      <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
    @endif

    <form wire:submit.prevent="updateDashboard">


      <section id="step1" class="bg-white shadow-md rounded-lg p-4">
        <h2 class="text-2xl font-bold mb-4">{{ __('strings.Select your interests') }}:</h2>
        <div class="d-flex align-items-center mb-4">
            <input type="checkbox" id="checkAllCategory" wire:click="toggleCheckAll"  />
            <label for="checkAllCategory" class="ms-2">{{ __('strings.Check All') }}</label>
        </div>
        <div class="row row-cols-1 row-cols-md-4 row-cols-xl-6 g-4">
       
          @foreach ($cats as $category)
            <div class="col">
              <div class="card-category bg-white shadow-xs">
                <div class="card-body d-flex bg-light align-items-center">
                  <div class="bg-orange-100 text-orange-500 rounded-circle d-flex justify-content-center align-items-center me-3">
                    <input type="checkbox" class="form-check-input text-orange-500 border-orange-400 category" {{ $userCategories->contains($category) ? 'checked' : '' }} id="category-{{ $category->id }}" name="categories[]" value="{{ $category->id }}" wire:model.defer="categories">
                   
                  </div>
                  <label wire:key="{{ $category->id }}" class="text-green-100" id="category" name="category" for="category-{{ $category->id }}">@if(app()->getLocale()=='ar'){{ strip_tags(htmlspecialchars_decode($category->name_ar)) }} @else{{ strip_tags(htmlspecialchars_decode($category->name)) }}@endif</label>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="d-flex justify-content-end">
          <button type="button" class="next-step btn btn-primary">{{ __('strings.Next') }}</button>
        </div>
      </section>

      <section id="step2" class="bg-white shadow-md rounded-lg p-4 mt-4 d-none">
        <h2 class="text-2xl font-bold mb-4">{{ __('strings.Select Service Type') }}</h2>

        <div class="row ">

          <div class="col-md-2  mb-3">
            <div class="card bg-light shadow-xs">
              <div class="card-body bg-green-100 d-flex align-items-center p-3">
                <input class="form-check-input me-3" type="radio" id="free-plan" name="service_type" value="free"  {{ $service_type == 'free' ? 'checked' : '' }}  wire:model.defer="service_type">
                <label class="form-check-label" for="free plan">Free Plan</label>
              </div>
              
            </div>
          </div>
         

          <div class="col-md-3 offset-md-1 mb-3">
            <div class="card bg-light shadow-xs">
              <div class="card-body d-flex bg-green-100 align-items-center p-3">
                <input class="form-check-input me-3" type="radio" id="premium-plan" name="service_type"  value="premium"  {{ $service_type == 'premuim' ? 'checked' : '' }}  wire:model.defer="service_type">

                <label class="form-check-label" for="premium plan">Premuium Plan</label>
              </div>

           
            </div>
          </div>

          
          <div id="free-plan-info" class="col-md-5" style="display: none;">
                <p>The free plan includes:</p>
                <ul>
                  <li>Limited features</li>
                  <li>Basic support</li>
                </ul>
                <p>Email only for firt interest you choose is available.</p>
                <div class="card-category bg-white shadow-xs">
                <div class="card-body d-flex bg-light align-items-center">
                <div class="bg-orange-100 text-orange-500 rounded-circle d-flex justify-content-center align-items-center me-3">
                <input type="checkbox" id="free-plan-email" name="contact-method" {{ $free_email == 'email' ? 'checked' : '' }}   wire:model.defer="free_email" value="email">
                <label for="free-plan-email">Email</label>
               </div>
               </div>
               </div>
          </div>

          <div id="premium-plan-info" class="col-md-5" style="display: none;">
              <p>The premium plan includes:</p>
              <ul>
                <li>Full set of features</li>
                <li>Priority support</li>
              </ul>
              <p>Email and WhatsApp services are available.</p>
              <div class="d-flex mb-2">
                <div class="card-category bg-white shadow-xs">
                  <div class="card-body d-flex bg-light align-items-center">
                    <div class="bg-orange-100 text-orange-500 rounded-circle d-flex justify-content-center align-items-center me-3">

                      <input type="checkbox" id="premium-plan-email" {{ $premium_email == 'email' ? 'checked' : '' }}  name="contact-method"wire:model.defer="premium_email"  value="email">

                      <label for="premium-plan-email">Email</label>
                    </div>
                  </div>
                </div>

                <div class="card-category bg-white shadow-xs">
                  <div class="card-body d-flex bg-light align-items-center">
                    <div class="bg-orange-100 text-orange-500 rounded-circle d-flex justify-content-center align-items-center me-3">
                      <input type="checkbox" id="premium-plan-whatsapp" {{ $whatsapp == 'whatsapp' ? 'checked' : '' }}  name="contact-method" wire:model.defer="whatsapp" value="whatsapp">
                      <label for="premium-plan-whatsapp">WhatsApp</label>
                    </div>
                  </div>
                </div>

              </div>
              @if ($hasPhone)
        
                <div class="row">
                <label class="text-success">{{ __('strings.Confirm Your Phone Number') }}</label>

                  <div class="col-md-5">
                    <div class="form-floating">
                        <select class="form-control block mt-1 py-1 w-full" id="country_code" name="country_code" wire:model.defer="country_code">
                        <option value="+966">+966 (Saudi Arabia)</option>
                        <option value="+20">+20 (Egypt)</option>
                        </select>
                    </div>
                  </div>
                  
                  <div class="col-md-7">
                      <div class="form-floating">
                      <input id="phone" class="form-control block mt-1 py-1 w-full " type="text" name="phone" maxlength="10"  required wire:model.defer="phone"/>
                      <label for="phone">{{ __('strings.Phone') }}</label>
                      @error('phone')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                      </div>
                  </div>

                </div>
              @endif



              
            </div>
        </div> 

        
       
           
   

        <div class="d-flex justify-content-between">
          <button type="button" class="prev-step btn btn-primary">{{ __('strings.Previous') }}</button>
          <button type="button" class="next-step btn btn-primary">{{ __('strings.Next') }}</button>
        </div>
      </section>

     
      <section id="step3" class="bg-white shadow-md rounded-lg p-4 mt-4 d-none">
        <h2 class="text-2xl font-bold mb-4">{{ __('strings.Select your favourite Regions') }}:</h2>
       
        <div class="row row-cols-1 row-cols-md-4 row-cols-xl-6 g-4">
          @foreach ($regs as $region)
            <div class="col">
              <div class="card bg-white shadow-xs">
                <div class="card-body bg-light d-flex align-items-center">
                  <div class="d-flex justify-content-center align-items-center me-3">
                  <input type="checkbox" class="form-check-input text-orange-500 border-orange-400 region" {{ $userRegions->contains($region) ? 'checked' : '' }} id="region-{{ $region->id }}" name="regions[]" value="{{ $region->id }}" wire:model.defer="regions">

                
                  </div>
                  <label class="text-green-100" id="region" name="region" for="region-{{ $region->id }}">@if(app()->getLocale()=='ar'){{ $region->name_ar }} @else{{ $region->name_en }}@endif</label>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="d-flex justify-content-between mt-3">
          <button type="button" class="prev-step btn btn-primary d-block mt-3 mb-3 pt-2 px-2">{{ __('strings.Previous') }}</button>
          <div class="d-flex">
          @if(app()->getLocale()=='ar')
          <input type="submit" wire:loading.remove value="تحديث" class="update btn btn-primary d-block mt-3 mb-3 pt-2 px-2">
          @else
          <input type="submit" wire:loading.remove value="Update" class="update btn btn-primary d-block mt-3 mb-3 pt-2 px-2">
          @endif
            <?php 
              $userSupscriptions = Auth::user()->supscriptions()->latest('created_at')->first();
              
              ?>  
              @if ($userSupscriptions != null) 

                  @if ($userSupscriptions->ends_at < now()) 
                    <a href="{{route('subscribe')}}" class="btn btn-primary d-block mt-3 mb-3 pt-2 px-2" >Renew Supscription</a>
                  @else
                    <div class="alert alert-success " role="alert" style="font-size:14px;">supscription ends at {{ \Carbon\Carbon::parse($userSupscriptions->ends_at)->format('Y-m-d') }}</div>


                  @endif

              @else 
              <button type="button" id="next-btn" class="next-step btn btn-primary d-block mt-3 mb-3 pt-2 px-2" >{{ __('strings.Subscribe Now') }}</button> 
              @endif  
          </div>
        </div>

      </section>  
     

    </form>

    <section id="step4" class="bg-white shadow-md rounded-lg p-4 mt-4 d-none">
        <div class="paymentWidgets"></div>
         <h1>Subscription</h1>
         <p>subscribe now to get all events around you in one place.</p>
         <p>you can choose services that suitable to you whether inform by whatsapp or inform by email.</p>
         <p>subscribe price include tax added to it.</p>
         
          @if ($userSupscriptions != null) 

              @if ($userSupscriptions->ends_at < now()) 
               <a href="{{route('subscribe')}}" class="p-2 btn btn-primary" >Renew Supscription</a>
              @else
               <div class="alert alert-success" role="alert">You have supscriped already. Your supscription ended at {{$userSupscriptions->ends_at}}</div>
 
               @endif

          @else 
            <a href="{{route('subscribe',['locale' => App::getLocale()])}}" class="p-2 btn btn-primary" >subscribe now</a>
          @endif       


      </section>    

      

  
    
     


       
</div>


@push('scripts')

<script>
 
 document.querySelectorAll('input[name="service_type"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
      if (this.value === 'free') {
        document.getElementById('free-plan-info').style.display = 'block';
        document.getElementById('premium-plan-info').style.display = 'none';
        document.getElementById('next-btn').style.display = 'none';
        document.getElementById('step4').style.display = 'none';
      } else {
        document.getElementById('free-plan-info').style.display = 'none';
        document.getElementById('premium-plan-info').style.display = 'block';
        document.getElementById('next-btn').style.display = 'block';
        document.getElementById('step4').style.display = 'block';
      }
    });

    radio.addEventListener('click', function() {
      if (this.value === 'free') {
        document.getElementById('free-plan-info').style.display = 'block';
        document.getElementById('premium-plan-info').style.display = 'none';
        document.getElementById('next-btn').style.display = 'none';
        document.getElementById('step4').style.display = 'none';
      } else {
        document.getElementById('free-plan-info').style.display = 'none';
        document.getElementById('premium-plan-info').style.display = 'block';
        document.getElementById('next-btn').style.display = 'block';
        document.getElementById('step4').style.display = 'block';
      }
    });
  });
          const nextStepButtons = document.querySelectorAll('.next-step');
          const prevStepButtons = document.querySelectorAll('.prev-step');
         
         
          const stepIndicators = document.querySelectorAll('.step-indicator');

          nextStepButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
              const currentStep = document.getElementById(`step${index + 1}`);
              const nextStep = document.getElementById(`step${index + 2}`);
              const currentStepIndicator = stepIndicators[index];
              const nextStepIndicator = stepIndicators[index + 1];

              currentStep.classList.add('d-none');
              nextStep.classList.remove('d-none');

              currentStep.classList.remove('step1-active');
              nextStep.classList.add('step1-active');

              currentStepIndicator.classList.remove('step1-active');
              nextStepIndicator.classList.add('step1-active');
            });
          });


          prevStepButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
              const currentStep = document.getElementById(`step${index + 2}`);
              const prevStep = document.getElementById(`step${index + 1}`);
              const currentStepIndicator = stepIndicators[index + 1];
              const prevStepIndicator = stepIndicators[index];

              currentStep.classList.add('d-none');
              prevStep.classList.remove('d-none');

              currentStep.classList.remove('step1-active');
              prevStep.classList.add('step1-active');

              currentStepIndicator.classList.remove('step1-active');
              prevStepIndicator.classList.add('step1-active');
            });
          });

        // $(document).ready(function() {
        //   $('#checkAllCategory').click(function(){
        //     $(".category").prop('checked',$(this).prop('checked'));
        //   });
        //   $('#checkAllRegion').click(function(){
        //     $(".region").prop('checked',$(this).prop('checked'));
        //   });


        // }) ;  

         
    

</script>


  @endpush
  