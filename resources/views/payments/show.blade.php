<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pagamento — Pedido #{{ $order->order_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if ($errors->any())
                <div class="p-4 bg-red-100 text-red-800 rounded-md text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <p class="text-sm text-gray-500">Total a pagar</p>
                <p class="text-3xl font-bold text-green-600">R$ {{ number_format($order->total, 2, ',', '.') }}</p>
            </div>

            @if ($order->payment_method === 'pix')
                <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                    <h3 class="font-semibold text-gray-900 mb-4">Pague com Pix</h3>
                    <img src="data:image/png;base64,{{ $pixQrImage }}" alt="QR Code Pix" class="mx-auto w-56 h-56">

                    <p class="text-sm text-gray-500 mt-4 mb-2">Ou use o Pix Copia e Cola:</p>
                    <div class="bg-gray-100 p-3 rounded-md text-xs break-all font-mono">{{ $pixPayload }}</div>

                    <form method="POST" action="{{ route('payments.process', $order->order_number) }}" class="mt-6">
                        @csrf
                        <x-primary-button class="w-full justify-center py-3">
                            Já paguei, confirmar
                        </x-primary-button>
                    </form>
                </div>
            @endif

            @if ($order->payment_method === 'boleto')
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Boleto Bancário</h3>

                    <p class="text-sm text-gray-500 mb-1">Linha digitável:</p>
                    <div class="bg-gray-100 p-3 rounded-md text-sm font-mono mb-4">{{ $linhaDigitavel }}</div>

                    <a href="{{ route('payments.boleto-pdf', $order->order_number) }}" target="_blank"
                        class="inline-block bg-gray-800 text-white text-sm px-4 py-2 rounded-md hover:bg-gray-900">
                        Baixar boleto em PDF
                    </a>

                    <form method="POST" action="{{ route('payments.process', $order->order_number) }}" class="mt-6">
                        @csrf
                        <x-primary-button class="w-full justify-center py-3">
                            Já paguei, confirmar
                        </x-primary-button>
                    </form>
                </div>
            @endif

            @if ($order->payment_method === 'cartao')
                <form method="POST" action="{{ route('payments.process', $order->order_number) }}" class="bg-white rounded-lg shadow-sm p-6 space-y-4" x-data="{
                    number: '',
                    brand: '',
                    detectBrand() {
                        let n = this.number.replace(/\D/g, '');
                        if (/^4/.test(n)) this.brand = 'Visa';
                        else if (/^5[1-5]/.test(n) || /^2(2[2-9]|[3-6]\d|7[01]|720)/.test(n)) this.brand = 'Mastercard';
                        else if (/^3[47]/.test(n)) this.brand = 'American Express';
                        else if (/^636368|^438935|^504175|^451416|^636297|^5067|^4576|^4011/.test(n)) this.brand = 'Elo';
                        else if (/^606282/.test(n)) this.brand = 'Hipercard';
                        else this.brand = n.length >= 4 ? 'Não identificada' : '';
                    }
                }">
                    @csrf
                    <h3 class="font-semibold text-gray-900">Dados do Cartão</h3>

                    <div>
                        <x-input-label for="card_number" :value="__('Número do Cartão')" />
                        <x-text-input id="card_number" name="card_number" type="text" class="mt-1 block w-full"
                            x-model="number" @input="detectBrand()" placeholder="0000 0000 0000 0000" maxlength="19" required />
                        <p class="text-sm mt-1 font-medium" x-show="brand" x-text="'Bandeira: ' + brand"></p>
                        <x-input-error :messages="$errors->get('card_number')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="card_name" :value="__('Nome impresso no cartão')" />
                        <x-text-input id="card_name" name="card_name" type="text" class="mt-1 block w-full" required />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="card_expiry" :value="__('Validade (MM/AA)')" />
                            <x-text-input id="card_expiry" name="card_expiry" type="text" class="mt-1 block w-full" placeholder="12/28" required />
                        </div>
                        <div>
                            <x-input-label for="card_cvv" :value="__('CVV')" />
                            <x-text-input id="card_cvv" name="card_cvv" type="text" class="mt-1 block w-full" maxlength="4" required />
                        </div>
                    </div>

                    <p class="text-xs text-gray-500">Este é um ambiente simulado. Nenhum dado de cartão é armazenado.</p>

                    <x-primary-button class="w-full justify-center py-3">
                        Pagar Agora
                    </x-primary-button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>