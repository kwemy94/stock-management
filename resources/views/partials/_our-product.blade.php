<section id="features" class="features">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title mx-auto text-center">
                    <span>{{ __('home.our-item.our-product') }}</span>
                    <h2>{{ __('home.our-item.title') }} </h2>
                    <p>
                        {{ __('home.our-item.introduction') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            {{-- <div class="col-xl-4 col-md-6 col-sm-9">
                <div class="single-feature wow fadeInUp" data-wow-delay=".1s">
                    <div class="feature-icon">
                        <i class="lni lni-hand"></i>
                    </div>
                    <div class="feature-content">
                        <h3 class="feature-title">Easy to use</h3>
                        <p class="feature-desc">
                            Lorem Ipsum is simply dummy text of the printing and industry.
                        </p>
                    </div>
                </div>
            </div> --}}
            <div class="col-xl-4 col-md-6 col-sm-9">
                <div class="single-feature wow fadeInUp" data-wow-delay=".15s">
                    <div class="feature-icon">
                        <i class="lni lni-lock"></i>
                    </div>
                    <div class="feature-content">
                        <h3 class="feature-title">{{ __('home.our-item.title') }}</h3>
                        <p class="feature-desc">
                            Souscrivez à notre produit et bénéficier d'une réduction allant jusqu'à 10%

                            {{-- <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#supcription_app">
                                Souscrire ...
                            </button> --}}
                        </p>
                    </div>
                </div>
            </div>
            {{-- <div class="col-xl-4 col-md-6 col-sm-9">
                <div class="single-feature wow fadeInUp" data-wow-delay=".2s">
                    <div class="feature-icon">
                        <i class="lni lni-layout"></i>
                    </div>
                    <div class="feature-content">
                        <h3 class="feature-title">High-quality Design</h3>
                        <p class="feature-desc">
                            Lorem Ipsum is simply dummy text of the printing and industry.
                        </p>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

    <!-- Modal -->
    {{-- <div class="modal fade" id="supcription_app" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">App de Gestion de stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                      <div class=" mb-3">
                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                        <input type="text" class="form-control" id="recipient-name">
                      </div>
                      <div class="mb-3">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                      </div>
                    </form>
                  </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-primary">Enregister</button>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- @include('partials.modal.modal') --}}
</section>
