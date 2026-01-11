@extends('layouts.app')

@section('title', 'Modifier ressource')

@section('content')
  <h1>Modifier la ressource</h1>

  <form class="card" method="post" action="{{ route('admin.resources.update', $resource) }}">
    @csrf
    @include('admin.resources.partials.form', ['resource' => $resource])
    <button class="btn" type="submit">Enregistrer</button>
  </form>
@endsection
