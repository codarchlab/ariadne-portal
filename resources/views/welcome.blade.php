@extends('app')

@section('content')
<aside class="right-side">                
    <!-- Main content -->
    <section class="content">
                <h2>Ariadne Portal</h2>
                <div class="quote">{{ Inspiring::quote() }}</div>
            </div>
    </section>
</aside>
@endsection