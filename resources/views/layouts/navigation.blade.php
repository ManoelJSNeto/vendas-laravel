<nav x-data="{
    open: false,
    darkMode: document.documentElement.classList.contains('dark'),
    toggleDarkMode() {
        this.darkMode = !this.darkMode;
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        }
    }
}" class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 sticky top-0 z-40 transition-colors">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                        <x-application-logo class="block h-8 w-8 text-navy-800 dark:text-sky-400" />
                        <span class="font-bold text-lg tracking-tight text-slate-900 dark:text-white hidden md:inline">Vendas Laravel</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-8 sm:flex">
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                        </svg>
                        {{ __('Produtos') }}
                    </x-nav-link>
                    <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        {{ __('Carrinho') }}
                    </x-nav-link>
                    <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                        {{ __('Meus Pedidos') }}
                    </x-nav-link>

                    @if (Auth::user()?->is_admin)
                        <div class="h-6 w-px bg-slate-200 dark:bg-slate-700 self-center mx-1"></div>
                        <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                            {{ __('Admin: Produtos') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                            {{ __('Admin: Vendas') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            {{ __('Admin: Usuários') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                            {{ __('Admin: Categorias') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.mail-settings.edit')" :active="request()->routeIs('admin.mail-settings.*')">
                            {{ __('Admin: E-mail') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings & Theme Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-2">
                <!-- Dark Mode Toggle Button -->
                <button @click="toggleDarkMode()" type="button" aria-label="Alternar tema" class="p-2 text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors focus:outline-none focus:ring-2 focus:ring-slate-300 dark:focus:ring-slate-700 cursor-pointer">
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="4"></circle>
                        <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"></path>
                    </svg>
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-slate-200 dark:border-slate-700 text-sm leading-4 font-medium rounded-lg text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none transition ease-in-out duration-150 cursor-pointer">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1.5">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center gap-1 sm:hidden">
                <!-- Dark Mode Mobile Button -->
                <button @click="toggleDarkMode()" type="button" aria-label="Alternar tema" class="p-2 text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="4"></circle>
                        <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"></path>
                    </svg>
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                </button>

                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-slate-400 hover:text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none transition duration-150 ease-in-out cursor-pointer">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" stroke-width="1.75" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                {{ __('Produtos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                {{ __('Carrinho') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                {{ __('Meus Pedidos') }}
            </x-responsive-nav-link>
            @if (Auth::user()?->is_admin)
                <div class="my-2 border-t border-slate-200 dark:border-slate-800"></div>
                <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                    {{ __('Admin: Produtos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                    {{ __('Admin: Vendas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    {{ __('Admin: Usuários') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                    {{ __('Admin: Categorias') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.mail-settings.edit')" :active="request()->routeIs('admin.mail-settings.*')">
                    {{ __('Admin: E-mail') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-slate-200 dark:border-slate-800 px-4">
            <div class="mb-3">
                <div class="font-medium text-base text-slate-800 dark:text-slate-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500 dark:text-slate-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
