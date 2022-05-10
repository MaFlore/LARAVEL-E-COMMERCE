@extends('layouts.master')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('contenu')
    @if ( Cart::count() > 0 )
        <div class="px-4 px-lg-0">
        <div class="pb-5">
            <div class="container">
            <div class="row">
                <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">
                <div class="table-responsive">
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col" class="border-0 bg-light">
                            <div class="p-2 px-3 text-uppercase">Produits</div>
                        </th>
                        <th scope="col" class="border-0 bg-light">
                            <div class="py-2 text-uppercase">Prix</div>
                        </th>
                        <th scope="col" class="border-0 bg-light">
                            <div class="py-2 text-uppercase">Quantités</div>
                        </th>
                        <th scope="col" class="border-0 bg-light">
                            <div class="py-2 text-uppercase">Delete</div>
                        </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Cart::content() as $produit)
                        <tr>
                            <th scope="row" class="border-0">
                                <div class="p-2">
                                <img src="{{ asset('storage/'.$produit->image) }}" alt="" width="70" class="img-fluid rounded shadow-sm">
                                <div class="ml-3 d-inline-block align-middle">
                                    <h5 class="mb-0"> <a href="{{ route('products.details', ['slug' => $produit->model->slug]) }}" class="text-dark d-inline-block align-middle">
                                        {{ $produit->model->titre }}
                                    </a>
                                    </h5>
                                    <span class="text-muted font-weight-normal font-italic d-block">
                                        Catégories: @foreach ($produit->model->categories as $categorie)
                                        {{ $categorie->name }}{{ $loop->last ? '' : ', '}}
                                    @endforeach
                                </span>
                                </div>
                                </div>
                            </th>
                            <td class="border-0 align-middle"><strong></strong>{{ getPrix($produit->subtotal()) }}</td>
                            <td class="border-0 align-middle">
                                <select name="qty" id="qty" data-id="{{ $produit->rowId }}" class="custom-select">
                                    @for ($i = 1; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ $produit->qty == $i ? 'selected' : ''}}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </td>
                            <td class="border-0 align-middle">
                                <form action="{{ route('cart.remove', $produit->rowId)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red"><i class="fa fa-trash" aria-hidden="true"></i></td></button>
                                </form>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
                <!-- End -->
                </div>
            </div>

            <div class="row py-5 p-4 bg-white rounded shadow-sm">
                <div class="col-lg-6">
                <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Coupon code</div>
                <div class="p-4">
                    <p class="font-italic mb-4">If you have a coupon code, please enter it in the box below</p>
                    <div class="input-group mb-4 border rounded-pill p-2">
                    <input type="text" placeholder="Apply coupon" aria-describedby="button-addon3" class="form-control border-0">
                    <div class="input-group-append border-0">
                        <button id="button-addon3" type="button" class="btn btn-dark px-4 rounded-pill"><i class="fa fa-gift mr-2"></i>Apply coupon</button>
                    </div>
                    </div>
                </div>
                <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Instructions for seller</div>
                <div class="p-4">
                    <p class="font-italic mb-4">If you have some information for the seller you can leave them in the box below</p>
                    <textarea name="" cols="30" rows="2" class="form-control"></textarea>
                </div>
                </div>
                <div class="col-lg-6">
                <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Details de la commande</div>
                <div class="p-4">
                    <p class="font-italic mb-4">Shipping and additional costs are calculated based on values you have entered.</p>
                    <ul class="list-unstyled mb-4">
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Sous-total </strong><strong>{{ getPrix(Cart::subtotal()) }}</strong></li>
                    <!--<li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Shipping and handling</strong><strong>$10.00</strong></li>-->
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Tax</strong><strong>{{ getPrix(Cart::tax()) }}</strong></li>
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                        <h5 class="font-weight-bold">{{ getPrix(Cart::total()) }}</h5>
                    </li>
                    </ul><a href="{{route('caisse.index')}}" class="btn btn-dark rounded-pill py-2 btn-block">Passer à la caisse</a>
                </div>
                </div>
            </div>

            </div>
        </div>
        </div>
        @else
        <div class="col-md-12">
            <p>Votre panier est vide</p>
        </div>
    @endif

@section('contenu_js')
<script>
    var qty = document.querySelectorAll('#qty');
    Array.from(qty).forEach((element) => {
        element.addEventListener('change', function () {
            var rowId = element.getAttribute('data-id');
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(
                `/panier/${rowId}`,
                {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    method: 'PATCH',
                    body: JSON.stringify({
                        qty: this.value
                    })
                }
            ).then((data) => {
                console.log(data);
                location.reload();
            }).catch((error) => {
                console.log(error);
            });
        });
    });
</script>
@endsection
@endsection
