@extends('ent.layout')
@section('title','แก้ไขใบประกาศ')

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
            <div class="card" style="width: 80%; top:100px; height:2100px">
                <div class="card-header" style="background-color:#6369ED; color:White; height:40px;">
                    <p class="card-text" style="font-size: 18px;">แก้ไขประกาศรับสมัครพนักงาน</p>
                </div>

                <div class="card-body">
                    <form action="{{ route('ent.ent_update_post',$jobs_edit->jobs_id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="nameCompany">ชื่อบริษัท</label>
                            <input type="text" class="form-control" name="jobs_name_company" placeholder="กรุณากรอกชื่อบริษัท" value="{{$jobs_edit->jobs_name_company}}">
                        </div>

                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleFormControlFile1">โลโก้บริษัท</label>
                                    <input type="file" name="logo" accept="image/*" class="form-control-file" id="exampleFormControlFile1">
                                    <img src="{{ asset('uploads/logo/'.$jobs_edit->logo) }}" width="100px" height="70px" alt="logo">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="rank">ตำแหน่งงานที่ต้องการ</label>
                                <input type="text" class="form-control" name="jobs_name" placeholder="กรุณากรอกตำแหน่งงาน" value="{{$jobs_edit->jobs_name}}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="quantity">จำนวนที่ต้องการ</label>
                                <input type="text" class="form-control" name="jobs_quantity" placeholder="จำนวนที่ต้องการ" value="{{$jobs_edit->jobs_quantity}}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="quantity">จำนวนเงินเดือน</label>
                                <input type="text" class="form-control" name="jobs_salary" placeholder="เงินเดือน" value="{{$jobs_edit->jobs_salary}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">ประเภทของงาน</label>
                            <select class="form-control" name="jobs_type" value="{{$jobs_edit->jobs_type}}" id="exampleFormControlSelect1">
                                <option value="fulltime" {{ $jobs_edit->jobs_type == "fulltime" ? 'selected' : '' }}>Fulltime</option>
                                <option value="pasttime" {{ $jobs_edit->jobs_type == "pasttime" ? 'selected' : '' }}>Pasttime</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">ประเภทการทำงาน</label>
                            <select class="form-control" name="location_work" value="{{$jobs_edit->location_work}}" id="exampleFormControlSelect1">
                                <option value="wfh" {{ $jobs_edit->location_work == "wfh" ? 'selected' : '' }}>Work From Home</option>
                                <option value="company" {{ $jobs_edit->location_work == "company" ? 'selected' : '' }}>At Company</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">ข้อความในการโพสต์</label>
                            <textarea class="form-control" name="jobs_detail" id="exampleFormControlTextarea1" rows="8">{{$jobs_edit->jobs_detail}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="nameCompany">ข้อมูลการติดต่อ</label>
                            <textarea class="form-control" name="jobs_contact" id="exampleFormControlTextarea1" rows="8">{{$jobs_edit->jobs_contact}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">ที่อยู่ของบริษัท</label>
                            <textarea class="form-control" name="jobs_address" id="exampleFormControlTextarea1" rows="8">{{$jobs_edit->jobs_address}}</textarea>
                            <input type="hidden" name="lat" value="{{$jobs_edit->lat}}" id="loc_lat" />
                            <input type="hidden" name="lng" value="{{$jobs_edit->lng}}" id="loc_long" />
                        </div>

                        <div class="form-group">
                            <p>กดเพื่อบันทึกพิกัดที่ตั้งบริษัท</p>
                            <div id="map"></div>
                        </div>

                        <div class="form-group" style="float:right; margin-top:650px;">
                            <a href="{{ route('ent_list_post') }}" class="btn btn-danger">ยกเลิก</a>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script type=text/javascript>
        var map, pcp;
        const jobs_edit = @json($jobs_edit);

        function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 20,
            });
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                        pos = {
                            lat: parseFloat(jobs_edit.lat),
                            lng: parseFloat(jobs_edit.lng)
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