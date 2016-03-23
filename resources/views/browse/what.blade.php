@extends('app')
@section('content')
            
<style>
.whatBlock {
  margin-top: 80px;
  margin-left: 20px;
  margin-right: 20px;
}
</style>

<div class='whatBlock'>
  
  <!-- START WORD CLOUD -->
  <div id="wordCloud" class="wordCloudContainerWhat">
    @include('shared._word_cloud')
  </div>
  <!-- END WORD CLOUD -->

  
  <h1>The new Triumph Street Twin</h1>
  <p>With its new chassis the Street Twin is agile around town offers a plush ride. A new seat with 25% thicker padding enhances the ride quality and lets you ride all day with no aches or pains. The Triumph is low enough for feet-down at the lights, but not too cramped for tall riders.</p>
  <p>The Street Twin handles brilliantly. The 198kg (dry) machine is light, agile, has excellent full lean stability and acres of ground clearance. The single disc twin-piston Nissin brake set-up has impressive feel and power, too.</p>
  <p>The Triumph has an 18” front wheel for retro looks, which takes a bit of getting used to after 17-inchers, so the front end needs more muscle to get into a corner, but once you’re in and powering through, the Street Twin is completely stable.</p>
  
</div> 

@endsection