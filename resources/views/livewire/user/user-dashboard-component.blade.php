
         <style>.step1-active {
            background-color: #0E2E50;
            border-color: #0E2E50;
          }</style>
         <div>
            <div class="container my-5">
              <div class="row justify-content-center mb-4">
                <div class="col-auto d-flex align-items-center">
                  <div class="d-flex align-items-center step-indicator step1-active">
                <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 3rem; height: 3rem;">1 </div>
                  </div>
                  <div style="width: 7rem; height: 5px; background-color: #d3ced1"></div>



                  <div class="d-flex align-items-center step-indicator">
                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 3rem; height: 3rem;">2</div>
                  </div>
                  <div  style="width: 7rem; height: 5px; background-color: #d3ced1"></div>

                  <div class="d-flex align-items-center step-indicator">
                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 3rem; height: 3rem;">3</div>
                  </div>
                </div>
              </div>

              <div class="container">
                @if (Session::has('message'))
                <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
                @endif

                <form wire:submit.prevent="updateDashboard">
                  <div id="step1" class="bg-white shadow-md rounded-lg p-4">
                    <h2 class="text-2xl font-bold mb-4">Select your interests:</h2>

                    <div class="row row-cols-1 row-cols-md-4 row-cols-xl-6 g-4">
                      @foreach ($cats as $category)
                      <div class="col">
                        <div class="card-category bg-white shadow-xs">
                          <div class="card-body d-flex bg-light align-items-center ">
                            <div class="bg-orange-100 text-orange-500 rounded-circle d-flex justify-content-center align-items-center  me-3">
                              <input type="checkbox" class="form-check-input text-orange-500 border-orange-400 " id="category-{{ $category->id }}" name="categories[]" value="{{ $category->id }}" wire:model.defer="categories.{{ $category->id }}" @if ($userCategories->contains($category)) checked @endif />
                            </div>
                            <label class="text-green-100" id="category" name="category" for="category-{{ $category->id }}">{{ strip_tags(htmlspecialchars_decode($category->name)) }}</label>
                          </div>
                        </div>
                      </div>
                      @endforeach
                    </div>

                    <div class="d-flex justify-content-end">
                      <button type="button" class="next-step btn btn-primary">Next</button>
                    </div>
                  </div>

                  <div id="step2" class="bg-white shadow-md rounded-lg p-4 mt-4 d-none">
                    <h2 class="text-2xl font-bold mb-4">Select Service Type</h2>

                    <div class="row row-cols-1 row-cols-md-4 row-cols-xl-6 g-4">
                      <div class="col-md-3 offset-3 mb-3 ">
                        <div class="card bg-light shadow-xs">
                          <div class="card-body bg-green-100 d-flex align-items-center p-3">
                            <input class="form-check-input   me-3" type="radio" wire:model="service_type" name="service_type" value="whatsapp"  @if ($service ==='whatsapp') checked @endif >
                            <label class="form-check-label " for="whatsapp">WhatsApp</label>
                          </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="card bg-light shadow-xs">
                          <div class="card-body d-flex bg-green-100 align-items-center p-3">
                            <input class="form-check-input   me-3" type="radio" wire:model="service_type" name="service_type" value="email " @if ($service ==='email') checked @endif>
                            <label class="form-check-label " for="email">Email</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="d-flex justify-content-between">
                      <button type="button" class="prev-step btn btn-primary">Previous</button>
                      <button type="button" class="next-step btn btn-primary">Next</button>
                    </div>
                  </div>

                  <div id="step3" class="bg-white shadow-md rounded-lg p-4 mt-4 d-none">
                    <div class="row row-cols-1 row-cols-md-4 row-cols-xl-6 g-4">
                      @foreach ($regs as $region)
                      <div class="col">
                        <div class="card bg-white shadow-xs">
                          <div class="card-body bg-light d-flex align-items-center ">
                            <div class=" d-flex justify-content-center align-items-center  me-3">
                              <input type="checkbox" class="form-check-input text-orange-500 border-orange-400" id="region-{{ $region->id }}" name="regions[]" value="{{ $region->id }}" wire:model.defer="regions.{{ $region->id }}" @if ($userRegions->contains($region)) checked @endif>
                            </div>
                            <label class="text-green-100" id="region" name="region" for="region-{{ $region->id }}">{{ $region->name_ar }}</label>
                          </div>
                        </div>
                      </div>
                      @endforeach
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                      <button type="button" class="prev-step btn btn-primary">Previous</button>
                      <input type="submit" value="Update" class="btn btn-primary">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>



      @push('scripts')

      <script>
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

            currentStep.classList.add('hidden');
            prevStep.classList.remove('hidden');

            currentStep.classList.remove('step1-active');
            prevStep.classList.add('step1-active');

            currentStepIndicator.classList.remove('step1-active');
            prevStepIndicator.classList.add('step1-active');
          });
        });
      </script>


@endpush


