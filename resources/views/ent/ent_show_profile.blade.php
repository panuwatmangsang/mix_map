@extends('ent.layout')
@section('title','แสดงข้อมูลบริษัท')

@section('cssBlock')
<!-- css -->
<link rel="stylesheet" href="/jobs_it/css/map_post.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwWR2wmPRsSwSK0H47H9pqdMQqigSdF34&callback=initMap&libraries=&v=weekly" async></script>
@stop

@section('content')

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card" style="width: 80%; top:100px; height:1300px">
                <div class="card-header" style="background-color:#6369ED; color:White; height:40px;">
                    <p class="card-text" style="font-size: 18px;">แสดงรายละเอียดข้อมูลบริษัท</p>
                </div>

                <div class="card-body">
                    @if(isset($profiles))
                    <form action="#" method="post">
                        @csrf

                        <div class="form-row col align-self-center" align="center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleFormControlFile1">โลโก้บริษัท</label> <br>
                                    <img src="{{ asset('uploads/profile_logo/'.$profiles->profile_logo) }}" width="100px" height="130px" alt="logo">
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="nameCompany">ชื่อบริษัท</label>
                            <input type="text" class="form-control" name="profile_name_company" value="{{$profiles->profile_name_company}}" placeholder="กรุณากรอกชื่อบริษัท">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="rank">ชื่อผู้ติดต่อ</label>
                                <input type="text" class="form-control" name="profile_company_contact" value="{{$profiles->profile_company_contact}}" placeholder="กรุณากรอกชื่อผู้ติดต่อ">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="quantity">เบอร์โทรศัพท์</label>
                                <input type="text" class="form-control" name="profile_company_phone" value="{{$profiles->profile_company_phone}}" placeholder="เบอร์โทรศัพท์">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nameCompany">อีเมล</label>
                            <input type="text" class="form-control" name="profile_email" value="{{$profiles->profile_email}}" placeholder="กรุณากรอกอีเมล">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">ที่อยู่ของบริษัท</label>
                            <textarea class="form-control" name="profile_company_address" id="exampleFormControlTextarea1" rows="8">{{$profiles->profile_company_address}}</textarea>
                            <input type="hidden" name="profile_lat" value="{{$profiles->profile_lat}}" id="loc_lat" />
                            <input type="hidden" name="profile_lng" value="{{$profiles->profile_lng}}" id="loc_long" />
                        </div>

                        <div class="form-group">
                            <p>กดเพื่อบันทึกพิกัดที่ตั้งบริษัท</p>
                            <div id="map"></div>
                        </div>

                        <div class="form-group" style="float:right; margin-top:450px;">
                            <a href="{{ route('ent_list_post') }}" class="btn btn-danger">กลับ</a>
                        </div>
                    </form>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <script type=text/javascript>
        var map, pcp;
        const get_show_profile = @json($profiles);

        function initMap() {

            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 20,
            });
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {

                        pos = {
                            lat: parseFloat(get_show_profile.profile_lat),
                            lng: parseFloat(get_show_profile.profile_lng)
                        };
                        // console.log("0")
                        // console.log(pos)
                        map.setCenter(pos);
                        const marker = new google.maps.Marker({
                            position: pos,
                            map,
                            title: "ที่ตั้งบริษัท",
                        });
                        marker.addListener("click", () => {
                            map.setCenter(marker.getPosition());
                        });
                        const infowindow = new google.maps.InfoWindow({
                            content: marker.getTitle(),
                            position: marker.getPosition()
                        });
                        marker.addListener('click', () => {
                            infowindow.open({
                                anchor: marker,
                                map,
                                shouldFocus: false
                            });
                        });
                        google.maps.event.addListener(marker, 'click', function() {
                            infowindow.setContent('<p>กดเพื่อบันทึกพิกัดที่ตั้งบริษัท');
                            infowindow.open(map, this);
                        });
                        google.maps.event.addListener(map, 'click', function(event) {
                            latlng = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
                            marker.setPosition(latlng);
                            // console.log("001")
                            // console.log(marker.position.lat())
                            // console.log(marker.position.lng())
                            pcp = {
                                lat: marker.position.lat(),
                                lng: marker.position.lng(),
                            };
                            document.getElementById('loc_lat').value = marker.position.lat();
                            document.getElementById('loc_long').value = marker.position.lng();
                        });
                    },
                    function() {
                        handleLocationError(true, infoWindow, map.getCenter());
                    });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }
            const infoWindow = new google.maps.InfoWindow();

        }
    </script>
</body>
@endsection