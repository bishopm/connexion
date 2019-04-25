<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
<img src="{{asset('/vendor/bishopm/themes/' . $setting['website_theme'] . '/images/contact.png')}}">
<h4>Find us</h4>
<ul class="list-unstyled top17">
    <li><b>Sunday services:</b> 07h00 | 08h30 | 1000</li>
    <li><b>Children and youth:</b> Sundays 08h30</li>
</ul>
<p style="text-align:center;">
    @if ($setting['home_latitude'] <> 'Church latitude')
        <a href="{{url('/contact')}}">
            <div id='map' style='height: 200px;'></div>
        </a>
        <script>
            var mymap = L.map('map').setView([{
                {
                    $setting['home_latitude']
                }
            }, {
                {
                    $setting['home_longitude']
                }
            }], 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox.streets',
                accessToken: 'pk.eyJ1IjoiYmlzaG9wbSIsImEiOiJjanNjenJ3MHMwcWRyM3lsbmdoaDU3ejI5In0.M1x6KVBqYxC2ro36_Ipz_w'
            }).addTo(mymap);
            var marker = L.marker([{
                {
                    $setting['home_latitude']
                }
            }, {
                {
                    $setting['home_longitude']
                }
            }]).addTo(mymap);
        </script>
        @else
        To include a map, please add church co-ordinates in back-end
        @endif
</p>
<ul class="list-unstyled top10">
    <li><i class="fa fa-phone"></i> <b>032 947 0173</b></li>
    <li><a href="{{url('/')}}/contact">Interactive map and full contact details</a></li>
</ul>