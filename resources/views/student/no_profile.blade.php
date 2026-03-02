@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Student Profile Not Found</h2>
    <p>{{ $error ?? 'Your student profile is missing. Please contact the administrator.' }}</p>
</div>
@endsection