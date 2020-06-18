@extends('layouts.app')

@section('content')

    <campaign data-campaign="{{json_encode($campaign)}}"
{{--              data-categories="{{json_encode($categories)}}"--}}
{{--              data-donations="{{json_encode($donations)}}"--}}
    ></campaign>

@endsection