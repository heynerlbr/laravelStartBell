@extends('layouts.dastone')

@section('title', 'Inicio')

@section('content_header')
    Bienvenido(a) - Mantenimiento Sanmarino Integral
@stop

@section('content')

    <div>
     
    </div>
    <div  id="app" style="padding: 1%;">

{{--      
        <img class="imgr" src="{{asset('imagenes/muscular-car-service-worker-repairing-vehicle.jpg')}}" >
        <img class="imgr" src="{{asset('imagenes/various-work-tools-on-worktop.jpg')}}" >
        <img class="imgr"src="{{asset('imagenes/mechanic-changing-engine-oil-on-car-vehicle.jpg')}}" >      --}}

    </div>  



   
    
@stop

@section('css')

<style>
    .imgr{
        width: 300px;
        height:300px;
        border-radius: 50%;
        margin:5%;        
    }

    .imgr:hover{
        transform: scale(1.5);
    }

    @media (max-width: 600px) {
        .imgr:hover{
        transform: scale(1.1);
    }
}

</style>
  
@stop

@section('js')

@stop