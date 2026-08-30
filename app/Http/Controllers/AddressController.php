<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AddressController extends Controller
{
    public function index(Request $request): View
    {
        $addresses = $request->user()->addresses()->orderByDesc('is_default')->get();

        return view('profile.addresses', compact('addresses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'label' => ['nullable', 'string', 'max:255'],
            'cep' => ['required', 'string', 'max:9'],
            'logradouro' => ['required', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'bairro' => ['required', 'string', 'max:255'],
            'cidade' => ['required', 'string', 'max:255'],
            'uf' => ['required', 'string', 'max:2'],
        ]);

        $isFirst = $request->user()->addresses()->count() === 0;

        $request->user()->addresses()->create([
            ...$request->only(['label', 'cep', 'logradouro', 'numero', 'complemento', 'bairro', 'cidade', 'uf']),
            'is_default' => $isFirst,
        ]);

        return redirect()->route('addresses.index')->with('status', 'Endereço adicionado com sucesso!');
    }

    public function setDefault(Request $request, Address $address): RedirectResponse
    {
        abort_unless($address->user_id === $request->user()->id, 403);

        $request->user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return redirect()->route('addresses.index')->with('status', 'Endereço padrão atualizado!');
    }

    public function destroy(Request $request, Address $address): RedirectResponse
    {
        abort_unless($address->user_id === $request->user()->id, 403);

        $wasDefault = $address->is_default;
        $address->delete();

        if ($wasDefault) {
            $request->user()->addresses()->first()?->update(['is_default' => true]);
        }

        return redirect()->route('addresses.index')->with('status', 'Endereço removido!');
    }
}