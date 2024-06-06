   <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Contact Us</h1>
                    <p>Contact with us with number and email. Leave your message and contact details to answer your message .</p>
                </div>
                <div class="row g-4">
                    <div class="col-12">
                        <div class="row g-4">
                            <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex align-items-center bg-white rounded p-3" style="border: 1px dashed rgba(0, 185, 142, .3)">
                                        <div class="icon me-3" style="width: 45px; height: 45px;">
                                            <i class="fa fa-map-marker-alt text-primary"></i>
                                        </div>
                                        <span>{{$setting->address}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.3s">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex align-items-center bg-white rounded p-3" style="border: 1px dashed rgba(0, 185, 142, .3)">
                                        <div class="icon me-3" style="width: 45px; height: 45px;">
                                            <i class="fa fa-envelope-open text-primary"></i>
                                        </div>
                                        <span>{{$setting->email}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex align-items-center bg-white rounded p-3" style="border: 1px dashed rgba(0, 185, 142, .3)">
                                        <div class="icon me-3" style="width: 45px; height: 45px;">
                                            <i class="fa fa-phone-alt text-primary"></i>
                                        </div>
                                        <span>{{$setting->phone}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <iframe class="position-relative rounded w-100 h-100"
                            src="{{$setting->map}}"
                            frameborder="0" style="min-height: 400px; border:0;" allowfullscreen="" aria-hidden="false"
                            tabindex="0"></iframe>
                            <!-- <iframe  class="position-relative rounded w-100 h-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3411.4842976522323!2d29.951113225095202!3d31.23501397434592!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14f5c590c683dad7%3A0x128ecd9cd8d1df7d!2z2YPZiNio2LHZiiDYs9iq2KfZhtmE2Yo!5e0!3m2!1sar!2seg!4v1717358350422!5m2!1sar!2seg" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->
                    </div>
                    <div class="col-md-6">
                        <div class="wow fadeInUp" data-wow-delay="0.1s">
                            <p class="mb-4">We are viewing your message with interest. 
                              We always and constantly monitor your message. Please leave your message or inquiry and it will be answered as soon as possible.</p>
                            <h2 class="box-title">Leave a Message</h2>

                            @if (Session::has('message'))
                            <div class="alert alert-success " role="alert">{{Session::get('message')}}
                            </div>
                            @endif
                            <form  wire:submit.prevent="sendMessage">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="name" placeholder="Your Name" id="name"  class="block mt-1 w-full form-control" wire:model="name" >
                                            <label>Your Name<span>*</span></label>

                                            @error('name')
                                            <p class="text-danger">{{$message}}</p>

                                            @enderror
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" name="email" placeholder="Your Email" id="email"  class="block mt-1 w-full form-control" wire:model="email">
                                            @error('email')
                                            <p class="text-danger">{{$message}}</p>

                                            @enderror
                                            <label>Your Email<span>*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                        <input type="text" name="phone" placeholder="Your Phone" id="phone" class="block mt-1 w-full form-control" wire:model="phone">
                                            @error('phone')
                                            <p class="text-danger">{{$message}}</p>

                                            @enderror
                                            <label>Phone <span>*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea  class="block mt-1 w-full form-control" name="message" placeholder="Leave a message here" id="message" style="height: 150px" wire:model="message"></textarea>
                                            <label >Message</label>

                                            @error('message')
                                            <p class="text-danger">{{$message}}</p>

                                            @enderror
                                            <label>Message <span>*</span></label>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3" type="submit">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
