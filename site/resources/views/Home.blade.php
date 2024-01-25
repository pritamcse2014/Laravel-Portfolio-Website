@extends('Layout.app')

@section('content')

@section('title', 'Home')

@include('Component.HomeBanner')

@include('Component.HomeService')

@include('Component.HomeCourse')

@include('Component.HomeProject')

@include('Component.HomeTeamMember')

@include('Component.HomeContact')

@include('Component.HomeReview')

@endsection
