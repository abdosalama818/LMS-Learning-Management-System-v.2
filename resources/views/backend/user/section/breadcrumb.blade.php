<div class="breadcrumb-content d-flex flex-wrap align-items-center justify-content-between mb-5">
    <div class="media media-card align-items-center">
        <div class="media-img media--img media-img-md rounded-full">
            <img class="rounded-full" src="{{auth()->user()->photo ? asset("uploads/" . auth('web')->user()->photo) : asset('frontend/images/small-avatar-1.jpg')}}" alt="Student thumbnail image">
        </div>
        <div class="media-body">
            <h2 class="section__title fs-30">Howdy, {{auth('web')->user()->name}}</h2>





        </div><!-- end media-body -->
    </div><!-- end media -->

</div><!-- end breadcrumb-content -->
<div class="section-block mb-5"></div>
