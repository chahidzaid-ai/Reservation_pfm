@extends('layouts.app')

@section('title', 'Créer ressource')

@section('content')
  <h1>Créer une ressource</h1>

  <form class="card" method="post" action="{{ route('admin.resources.store') }}">
    @csrf
    @include('admin.resources.partials.form', ['resource' => null])
    <button class="btn" type="submit">Créer</button>
  </form>
@endsection
