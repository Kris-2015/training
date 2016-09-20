@extends('layouts.app')

@section('title', 'blog')

@section('page')
<!-- Url of other page -->
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset_timed('css/blog.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h2 align="center" class="slant"> SPORTS CAR MADNESS </h2>

            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <img src="img/jaguar_f_type.jpg" height="600px" width="1135px">
                    </div>

                    <input type="hidden" id="hit" value="page-view">

                    <div class="panel-body">
                        <h2 class="heading" align="center"> <strong>Jaguar F-Type</strong></h2>

                        <p> From its seductively long hood to its steeply raked windshield and wide rear haunches, the F-type is a stunner. Offered as both a coupe and a convertible, it gets a snarling 3.0-liter supercharged V-6 pumping out 340 hp to the rear wheels through a six-speed manual or eight-speed automatic. Racier S models get a boost to 380 hp and offer all-wheel drive with the automatic. Suspension tuning is firm, and the F-type is always eager to play, but the cost is an often harsh ride over bumpy roads. </p>

                        <p> <strong class="sub">What We Like: </strong> Coupe or convertible, the F-type is a piece of extraordinarily beautiful kinetic art. All models share the aforementioned rigidity, and their agility rivals the best in this class. The steering is quick and communicative, the grip is tenacious, and braking performance is outstanding. Power ranges from respectable to potent depending on how much you spend. Acceleration numbers are best with the paddle-shifted eight-speed automatic, but the six-speed manual is exceptionally slick. Interior noise levels are surprisingly subdued—until the driver summons full power, whereupon the exhaust note becomes loudly musical and addictive.</p>

                        <br>

                        <div class="row">
                            <img src="img/interior.jpg" class="interior">
                        </div>

                        <br>

                        <p> <strong class="sub">What we hate: </strong> The price for flat cornering attitudes and eager transient response is a stiff ride with head toss on lumpy pavement. The coupe's backlight looks vast outside, but the driver’s rear view in reality seems like a narrow slot that shrinks by about 50 percent when the rear spoiler deploys to show the driver the classic Jaguar leaper backward and upside down. Curb weights tend toward pudgy for an aluminum-intensive car. Also, Jaguar seems to have gotten carried away with exterior identification. There are 10 badges and logos stuck on the outer regions—one on each wheel center, one on each front fender, one on each door handle, one on the rear deck, and one mid-grille.</p>

                        <br>

                        <p> <strong class="sub"> Conclusion: </strong> The Jaguar F-Type is quick, precise, super gorgeous model. Revive the spirit of racing just at one glance.  </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <img src="img/porsche-panamera.jpg" width="1135px" height="600px">
                    </div>
                    <div class="panel-body">
                        <h2 class="heading" align="center"><strong>Panamera S E-Hybrid</strong></h2>
                        
                        <p class="slant"><strong>Porsche has tweaked its parallel hybrid superfast car for this 
                        second generation Panamera E-Hybrid, adding plug in-battery recharging that enables much more credible distances to be covered on electric-only propulsion while maintaining the impressive performance.</strong></p>

                        <p>The Panamera S E-Hybrid is at its most effective when left to its own devices in Hybrid mode to optimise its power sources as required. However, it is possible to choose electric-only mode by pressing the E-Power button on the vast centre console.</p>

                        <p><strong>What We Like: </strong> In Electric Mode, it is capable to drive you upto 22 miles non-stop. In full-electric mode, the Panamera E-Hybrid can accelerate to 31mph in 6.1sec and reach a top speed of 84mph, making it amply flexible for the kind of stop-start traffic that’s typical in city centres. Gliding along soundlessly and cocooned within the Panamera’s comfortable cabin, you become fully aware of the noise, pace and bustle of a city’s busy roads. </p>

                        <br>

                        <div class="row">
                            <div class="col-xs-6"><img src="img/interior_2.jpg" height="300px" width="580px"></div>
                            <div class="col-xs-6"><img src="img/interior_3.jpg" height="300px" width="550px"></div>
                        </div>

                        <br>

                        <p> <strong>What We Hate: </strong> The plug-in technology brings more of a burden than the first-generation hybrid, bumping the kerb weight to 2095kg, and the vehicle can feel cumbersome in the cut and thrust of heavy traffic. It can also be difficult to thread the five-metre-long car through tight gaps, a challenge accentuated by the poor visibility out of the rear.</p>

                        <p> <strong>Conclusion: </strong> Nevertheless, the Panamera E-Hybrid wins as a luxury car with an impressively broad range of capabilities, something that has only been enhanced by its plug-in tech.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 

@section('js-css')

@endsection