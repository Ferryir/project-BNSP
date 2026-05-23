<nav class="bg-[#1a2332] shadow-lg">
    <div class="max-w-screen-xl mx-auto">
        <div class="flex items-center">
            <a href="/beasiswa"
               class="relative px-6 py-4 text-sm font-medium transition-colors duration-200
                      {{ request()->is('beasiswa') && !request()->is('beasiswa/create') ? 'text-white' : 'text-gray-400 hover:text-gray-200' }}">
                Pilihan Beasiswa
                @if(request()->is('beasiswa') && !request()->is('beasiswa/create'))
                    <span class="absolute bottom-0 left-0 right-0 h-[3px] bg-[#d4a843] rounded-t-sm"></span>
                @endif
            </a>
            <a href="/beasiswa/create"
               class="relative px-6 py-4 text-sm font-medium transition-colors duration-200
                      {{ request()->is('beasiswa/create') ? 'text-white' : 'text-gray-400 hover:text-gray-200' }}">
                Daftar
                @if(request()->is('beasiswa/create'))
                    <span class="absolute bottom-0 left-0 right-0 h-[3px] bg-[#d4a843] rounded-t-sm"></span>
                @endif
            </a>
            <a href="/hasil"
               class="relative px-6 py-4 text-sm font-medium transition-colors duration-200
                      {{ request()->is('hasil') ? 'text-white' : 'text-gray-400 hover:text-gray-200' }}">
                Hasil
                @if(request()->is('hasil'))
                    <span class="absolute bottom-0 left-0 right-0 h-[3px] bg-[#d4a843] rounded-t-sm"></span>
                @endif
            </a>
        </div>
    </div>
</nav>