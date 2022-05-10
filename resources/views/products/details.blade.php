@extends('layouts.master')

@section('contenu')
      <div class="col-md-6">
        <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
          <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-success">Catégorie :
                @foreach ($produit->categories as $categorie)
                    {{ $categorie->name }}{{ $loop->last ? '' : ', '}}
                @endforeach
            </strong>
            <h5 class="mb-0">{{ $produit->titre }}</h5>
            <hr>
            <p class="mb-auto text-muted">{!! $produit->description !!}</p>
            <strong class="mb-auto text-muted">{{ $produit->getPrix() }}</strong>
            <form action="{{ route('cart.ajouter')}}" method="POST">
              @csrf
              <input type="hidden" name="produit_id" value="{{ $produit->id}}">
              <button type="submit" class="btn btn-dark">Ajouter au panier</button>
          </form>
          </div>
          <div class="col-auto d-none d-lg-block">
            <img src="{{ asset('storage/'.$produit->image) }}" alt="">
          </div>
        </div>
      </div>
@endsection

@section('contenu_js')
  <script>
    var mainImage = document.querySelector('#mainImage');
    var thumbnails = document.querySelectorAll('.img-thumbnail');

    thumbnails.forEach((element) => element.addEventListener('click', changeImage));

    function changeImage(e) {
      mainImage.src = this.src;
    }
  </script>
@endsection
