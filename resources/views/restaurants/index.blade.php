@extends('layout')
@section('header')
     Restaurant List
@endsection
@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>

    <ul class="nav nav-tabs">

        <li><a href="#listview" class="listview" data-toggle="tab">List View</a></li>
        <li><a href="#mapview" class="mapview" data-toggle="tab">Map View</a></li>

    </ul>

    <div class="uper listviews">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif
        <table class="table table-striped">
            <thead>
            <tr>
                <td>ID</td>
                <td>Restaurant Name</td>
                <td>Restaurant Address</td>
                <td>Restaurant Number</td>
                <td>Distance</td>
                <td>Direction</td>
                <td colspan="2">Action</td>
            </tr>
            </thead>
            <tbody>
            <?php $i = 0 ?>
            @foreach($restaurants as $rest)
                <?php $i++;
                $formattedAddr = str_replace(' ','+',$rest->rest_address);

                $geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=true_or_false&key=AIzaSyCd1ROM9OflA9ao8n1c1ctFcVD6SGafOrM');
                $output= json_decode($geocode);


                $lat2 = $output->results[0]->geometry->location->lat;
                $long = $output->results[0]->geometry->location->lng;
                $lat1 = $_COOKIE['clat'];
                $long1 = $_COOKIE['clong'];

                 $origin = $lat1.",".$long1;


                 $dest = $lat2.",".$long;

                $url = "https://www.google.com/maps/dir/?api=1&origin=$origin&destination=$dest&key=AIzaSyCd1ROM9OflA9ao8n1c1ctFcVD6SGafOrM";


                ?>
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$rest->rest_name}}</td>
                    <td>{{$rest->rest_address}}</td>
                    <td>{{$rest->tel_num}}</td>
                    <td>{{getDistanceBetweenPointsNew($lat1, $long1, $lat2, $long, $unit = 'Km')}} Km</td>
                    <td><a class="take_link" target="_blank" title="Take me there!" href="{{$url}}"><img alt="" src="{{ asset('directions.png') }}"></a></td>
                    <td><a href="{{ route('restaurants.edit',$rest->id)}}" class="btn btn-primary">Edit</a></td>
                    <td>
                        <form action="{{ route('restaurants.destroy', $rest->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>

    <div class="uper mapviews">
            Heena
    </div>
        <div class="pull-right">
            <a href="{{ route('restaurants.create')}}" class="btn btn-primary">Create new restaurant</a>
        </div>
@endsection



<?php
function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Km') {
    $theta = $longitude1 - $longitude2;
    $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $distance = acos($distance);
    $distance = rad2deg($distance);
    $distance = $distance * 60 * 1.1515; switch($unit) {
        case 'Mi': break; case 'Km' : $distance = $distance * 1.609344;
    }
    return (round($distance,2));
}
?>
