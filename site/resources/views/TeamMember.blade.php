@extends('Layout.app')

@section('title', 'Team Member')

@section('content')

    @include('Component.TeamMemberTopBanner')

    @include('Component.AllTeamMember')

@endsection
