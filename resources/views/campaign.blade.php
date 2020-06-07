@extends('layouts.app')

@section('content')

    <campaign data-post="{{json_encode($campaign)}}"
              data-categories="{{json_encode($categories)}}"
              data-categories="{{json_encode($donations)}}"
    ></campaign>

@endsection