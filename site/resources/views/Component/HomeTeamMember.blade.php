<div class="container section-marginTop text-center">
    <h1 class="section-title">টীম মেম্বার</h1>
    <h1 class="section-subtitle">আইটি কোর্স, প্রজেক্ট ভিত্তিক সোর্স কোড সহ আরো যে সকল সার্ভিস আমরা প্রদান করি </h1>
    <div class="row">

        @foreach($TeamMemberData as $TeamMemberData)

        <div class="col-md-3 p-2 ">
            <div class="card service-card text-center w-100">
                 <div class="card-body">
                     <img class="w-100" src="{{ $TeamMemberData->team_member_img }}" alt="Card image cap">
                     <h5 class="service-card-title mt-3">{{ $TeamMemberData->team_member_name }}</h5>
                     <h6 class="service-card-subTitle p-0 m-0">{{ $TeamMemberData->team_member_des }}</h6>
                 </div>
            </div>
        </div>

        @endforeach

    </div>
</div>

