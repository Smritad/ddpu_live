 @php
    $joinmembership = \App\Models\JoinMembershipDetail::whereNull('deleted_at')->first();
@endphp

 
  <section class="join-membership-sec">
        <div class="container">
            <div class="row">

            <div class="col-md-8">
                <div class="join-membership-content-sec">
                <h2 class="join-membership-title">{{ $joinmembership->heading }}</h2>
                <p>{{ $joinmembership->description }}</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="join-membership-btn-sec">
                <a href="{{ route('joinmembership.form') }}" class="btn-dark btn-lg">
                    <span>Join Now</span>
                </a>
                </div>
            </div>

            </div>
        </div>
   </section>
