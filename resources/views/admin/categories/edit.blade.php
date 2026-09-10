<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Categoria
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <x-input-label for="name" :value="__('Nome')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $category->name)" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="flex gap-3">
                    <x-primary-button>Salvar Alterações</x-primary-button>
                    <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-500 hover:underline self-center">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>