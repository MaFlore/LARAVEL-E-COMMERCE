@extends('layouts.master')

@section('contenu')
    @foreach ($produits as $produit)
      <div class="col-md-6">
        <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
          <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-success">Catégorie :
                @foreach ($produit->categories as $categorie)
                    {{ $categorie->name }}{{ $loop->last ? '' : ', '}}
                @endforeach
            </strong>
            <h5 class="mb-0">{{ $produit->titre }}</h5>
            <p class="mb-auto text-muted">{!! $produit->description !!}</p>
            <strong class="mb-auto text-muted">{{ $produit->getPrix() }}</strong>
            <a href="{{ route('products.details', $produit->slug) }}" class="stretched-link btn btn-info">Consulter le produit</a>
          </div>
          <div class="col-auto d-none d-lg-block">
            <img src="{{ asset('storage/'.$produit->image) }}" alt="">
          </div>
        </div>
      </div>
    @endforeach
{{-- Pagination --}}
<div class="d-flex justify-content-center">
    {!! $produits->appends(request()->input())->links() !!}
</div>
@endsection

