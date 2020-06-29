@extends('layouts.app')


@section('content')

    <post-form data-org="{{json_encode($organization)}}"></post-form>

@endsection