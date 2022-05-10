<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @foreach (Auth()->user()->orders as $order)
                    <div class="card mb-3">
                        <div class="card-header">
                            Commande passée le {{ Carbon\Carbon::parse($order->date_creation_payement)->format('d-m-Y à H:i')}} d'un montant de <strong>{{ getPrix($order->montant) }}</strong>
                        </div>
                        <div class="card-body">
                            <h6>Liste des produits</h6>
                            @foreach (unserialize($order->products) as $product)
                                <div>Nom du produit: {{ $product[0] }}</div>
                                <div>Prix: {{ getPrix($product[1]) }}</div>
                                <div>Quantité: {{ $product[2] }}</div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
