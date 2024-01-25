<div class="container mt-5">
    <div class="row">

        @foreach($TeamMemberData as $TeamMemberData)

            <div class="col-md-3 p-2 text-center">
                <div class="card">
                    <div class="card-body">
                        <img class="w-100" src="{{ $TeamMemberData->team_member_img }}" alt="Card image cap">
                        <h5 class="service-card-title mt-4">{{ $TeamMemberData->team_member_name }}</h5>
                        <h6 class="service-card-subTitle p-0 m-0">{{ $TeamMemberData->team_member_des }}</h6>
                    </div>
                </div>
            </div>

        @endforeach

    </div>

</div>
