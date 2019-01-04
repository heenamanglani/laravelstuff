<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" ng-app="RestaurantAdvisor">

<!--<script src="http://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCd1ROM9OflA9ao8n1c1ctFcVD6SGafOrM"></script>-->

<script src="http://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAZGtQGJr9f0UqR_9aLZlTYougTGP4fCkk"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>


<script type="text/javascript">

    google.maps.event.addDomListener(window, 'load', function () {
        var places = new google.maps.places.Autocomplete(document.getElementById('rest_address'));

        google.maps.event.addListener(places, 'place_changed', function () {

        });
    });




    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
           alert("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {

        document.cookie = "clat="+ position.coords.latitude;
        document.cookie = "clong="+ position.coords.longitude;

    }

    window.onload = getLocation;

</script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Restaurant Advisor</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />

</head>
<body>
<div class="container">
    <div class="card-header">
        @yield('header')
    </div>
    @yield('content')
</div>
<script src="{{ asset('js/app.js') }}" type="text/js"></script>
<script>

    jQuery(document).on('click', '.mapview', function () {

        jQuery('.listviews').hide();
        jQuery('.mapviews').show();

    });

    jQuery(document).on('click', '.listview', function () {

        jQuery('.mapviews').hide();
        jQuery('.listviews').show();
    });

</script>

</body>
</html>
