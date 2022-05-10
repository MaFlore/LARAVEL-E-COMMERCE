@extends('layouts.master')

@section('contenu')
    <h1 class="mx-auto"> Merci, votre demande a été traité avec succès !<h1>
    <a href="{{ route('products.index') }}"><button class="btn btn-info">Revenir à la boutique</button><a>
@endsection
