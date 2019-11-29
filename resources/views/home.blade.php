@extends('layouts.app')

@section('content')
    <core user="{{ Auth::user() }}" />
@endsection
