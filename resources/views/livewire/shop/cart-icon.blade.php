<button
    x-on:click="$dispatch('open-cart')"
    class="relative p-2 hover:bg-gray-100 rounded-lg transition-colors"
    aria-label="Ver carrito">
    <i class="fas fa-shopping-cart text-gray-600 text-xl hover:text-pink-600 transition-colors"></i>
    @if($cartCount > 0)
    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full min-w-[20px] h-5 flex items-center justify-center px-1 animate-pulse">
        {{ $cartCount > 99 ? '99+' : $cartCount }}
    </span>
    @endif
</button>