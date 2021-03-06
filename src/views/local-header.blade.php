@if (! $dark)
    {{-- Light version --}}
    <nav
        aria-label="Site navigation"
        x-init="init"
        x-data="{
            navIsOpen: false,
            activeSection: null,
            focusableElements: [],
            init: function () {
                this.focusableElements = Array.from(this.$refs.desktopNav.querySelectorAll('a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), [tabindex=\'0\']'));
            },
            toggle: function (section) {
                if (this.activeSection === section) {
                    return this.activeSection = null;
                }

                this.activeSection = section;
            },
            focusPreviousLink: function (event) {
                var index = this.focusableElements.indexOf(event.target);

                this.focusableElements[index - 1].focus();
            },
            focusNextLink: function (event, section = null) {
                if (section && this.activeSection !== section) {
                    return this.activeSection = section;
                }

                var index = this.focusableElements.indexOf(event.target);

                this.focusableElements[index + 1].focus();
            }
        }"
        class="py-3 bg-white"
        @keydown.window.escape="navIsOpen = false"
    >
        <div class="mx-auto px-4 text-gray-900 lg:flex lg:items-center lg:justify-between lg:px-16">
            <div class="flex items-center justify-between">
                <a class="inline-block text-black focus:outline-none focus:ring focus:ring-blue-500" href="/">
                    {{ $logo }}
                </a>
                <button
                    class="ml-6 flex-shrink-0 lg:hidden focus:outline-none focus:ring focus:ring-blue-500"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarContent"
                    aria-controls="navbarContent"
                    :aria-expanded="navIsOpen ? 'true' : 'false'"
                    aria-label="Toggle navigation"
                    @click="navIsOpen = ! navIsOpen"
                >
                    <svg aria-hidden="true" focusable="false" class="w-10 h-10 text-gray-900" viewBox="0 0 21 12" fill="none">
                        <g clip-path="url(#clip0)">
                            <path d="M20.35 10.13a.67.67 0 11-.96.92c-.8-.9-2.34-2.59-2.4-2.54a4.07 4.07 0 01-4.82.11 4.31 4.31 0 01-1.53-1.95 4.5 4.5 0 01.9-4.72 3.95 3.95 0 015.84 0 4.2 4.2 0 011.22 3.08c.01.9-.26 1.8-.77 2.54a36.2 36.2 0 002.52 2.56zm-7.9-2.98a2.77 2.77 0 003.14.65c.35-.15.67-.37.93-.65a2.87 2.87 0 00.85-2.12 3.12 3.12 0 00-.85-2.14A2.9 2.9 0 0014.47 2a2.67 2.67 0 00-2.04.89A2.96 2.96 0 0011.59 5a2.98 2.98 0 00.85 2.14zM.82 6.47c0-.37.3-.68.68-.68h5.24a.69.69 0 010 1.37H1.51a.69.69 0 01-.68-.69zm0-4.8c0-.38.3-.7.68-.7h5.9a.69.69 0 010 1.38h-5.9a.69.69 0 01-.68-.69zm0 9.6c0-.37.3-.68.68-.68h9.2a.69.69 0 110 1.37h-9.2a.69.69 0 01-.68-.68z" fill="#000"/>
                        </g>
                    </svg>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <div class="relative z-50" x-cloak>
                <div
                    x-show="navIsOpen"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-black bg-opacity-75 transition-opacity lg:hidden"
                    @click="navIsOpen = false"
                ></div>
                <div
                    id="navbarContent"
                    x-show="navIsOpen"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="-translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="-translate-x-full"
                    class="transform fixed inset-y-0 left-0 max-w-sm w-full px-4 pt-6 pb-16 bg-white overflow-y-auto transition-transform lg:hidden"
                >
                    <div class="flex items-start justify-between">
                        <a class="inline-block focus:outline-none focus:ring focus:ring-blue-500" href="/">
                            {{ $logo }}
                        </a>

                        <button
                            class="ml-8 focus:outline-none focus:ring focus:ring-blue-500"
                            type="button"
                            data-toggle="collapse"
                            data-target="#navbarContent"
                            aria-controls="navbarContent"
                            :aria-expanded="navIsOpen ? 'true' : 'false'"
                            aria-label="Close navigation"
                            @click="navIsOpen = false"
                        >
                            <svg aria-hidden="true" focusable="false" class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                    </div>

                    <ul class="mt-8 w-full">
                        @include('kernl-ui::includes.headers.search-mobile')

                        @foreach ($links as $link)
                            <li class="block">
                                @isset($link['children'])
                                    <a
                                        id="mobile-dropdown-{{ $loop->index }}"
                                        class="flex items-center justify-between py-4 whitespace-wrap border-b rounded-sm hover:bg-gray-100 focus:outline-none focus:ring focus:ring-blue-500"
                                        href="{{ $link['href'] }}"
                                        role="button"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        :aria-expanded="activeSection === {{ $loop->index }} ? 'true' : 'false'"
                                        @keydown.space.prevent="toggle({{ $loop->index }})"
                                        @click.prevent="toggle({{ $loop->index }})"
                                        {!! $currentPath == $link['href'] ? 'aria-current="page"' : '' !!}
                                    >
                                        {{ $link['text'] }}

                                        <svg aria-hidden="true" focusable="false" class="ml-2 w-4 h-4 text-gray-900" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    </a>
                                    <ul
                                        x-transition:enter="ease-out duration-300"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        x-transition:leave="ease-in duration-200"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        x-show="activeSection == {{ $loop->index }}"
                                        aria-labelledby="mobile-dropdown-{{ $loop->index }}"
                                    >
                                        @foreach ($link['children'] as $child)
                                            <li class="relative border-b">
                                                <span aria-hidden class="absolute inset-y-0 left-0 ml-1 flex items-center text-gray-600 text-xl leading-none">&middot;</span>
                                                <a
                                                    class="block py-4 pr-4 pl-6 hover:bg-gray-100 focus:outline-none focus:ring focus:ring-blue-500"
                                                    href="{{ $child['href'] }}"
                                                    {!! $currentPath == $child['href'] ? 'aria-current="page"' : '' !!}
                                                    {!! \Illuminate\Support\Str::startsWith($link['href'], '#') ? '@click="navIsOpen = false"' : '' !!}
                                                >
                                                    {{ $child['text'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <li class="block">
                                        <a
                                            class="inline-block w-full py-4 border-b rounded-sm hover:bg-gray-100 focus:outline-none focus:ring focus:ring-blue-500"
                                            href="{{ $link['href'] }}"
                                            {!! $currentPath == $link['href'] ? 'aria-current="page"' : '' !!}
                                            {!! \Illuminate\Support\Str::startsWith($link['href'], '#') ? '@click="navIsOpen = false"' : '' !!}
                                        >
                                            {{ $link['text'] }}
                                        </a>
                                    </li>
                                @endif
                            </li>
                        @endforeach
                        @isset($afterLinksMobile)
                            {{ $afterLinksMobile }}
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <div x-ref="desktopNav" class="hidden lg:block">
                <ul class="-mx-2 flex items-center">
                    @foreach ($links as $link)
                        @isset ($link['children'])
                            <li
                                class="relative"
                                @mouseenter="activeSection = {{ $loop->index }}"
                                @mouseleave="activeSection = null"
                            >
                                <a
                                    id="navbar-dropdown-{{ $loop->index }}"
                                    class="inline-flex items-center px-4 py-3 text-sm rounded-sm hover:bg-gray-100 focus:outline-none focus:ring focus:ring-blue-500"
                                    href="{{ $link['href'] }}"
                                    role="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    :aria-expanded="activeSection === {{ $loop->index }} ? 'true' : 'false'"
                                    @keydown.space.prevent="toggle({{ $loop->index }})"
                                    @keydown.enter.prevent="toggle({{ $loop->index }})"
                                    @keydown.arrow-down.prevent="focusNextLink($event, {{ $loop->index }})"
                                    {!! $currentPath == $link['href'] ? 'aria-current="page"' : '' !!}
                                >
                                    <span class="py-1 border-b-2 {{ isset($link['match']) && \Illuminate\Support\Str::of($currentPath)->start('/')->is($link['match']) ? 'border-gray-900' : 'border-transparent' }}">
                                        {{ $link['text'] }}
                                    </span>

                                    <svg aria-hidden="true" focusable="false" class="ml-2 w-4 h-4 text-gray-900" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </a>
                                <div
                                    :class="{ 'flex': activeSection === {{ $loop->index }}, 'hidden': activeSection !== {{ $loop->index }} }"
                                    aria-labelledby="navbar-dropdown-{{ $loop->index }}"
                                    class="absolute right-0 top-0 z-10 w-64 mt-12 flex-col items-start justify-start py-2 bg-white shadow-sm rounded-sm"
                                    x-cloak
                                >
                                    @foreach ($link['children'] as $child)
                                        <a
                                            class="
                                                block w-full py-2 px-3 text-sm leading-tight transition-colors duration-200 hover:text-gray-900 focus:outline-none focus:ring focus:ring-blue-500
                                                {{ $currentPath === $child['href'] ? 'text-gray-900' : 'text-gray-600' }}
                                            "
                                            href="{{ $child['href'] }}"
                                            @keydown.arrow-up.prevent="focusPreviousLink"
                                            @unless($loop->last)
                                                @keydown.arrow-down.prevent="focusNextLink"
                                            @endif
                                            {!! $currentPath == $child['href'] ? 'aria-current="page"' : '' !!}
                                        >
                                            <span
                                                class="block w-full px-2 border-l-2 {{ $currentPath === $child['href'] ? 'border-gray-600' : 'border-transparent' }}"
                                            >
                                                {{ $child['text'] }}
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </li>
                        @else
                            <li>
                                <a
                                    class="inline-flex px-4 py-3 text-sm rounded-sm hover:bg-gray-100 focus:outline-none focus:ring focus:ring-blue-500"
                                    href="{{ $link['href'] }}"
                                    {!! $currentPath == $link['href'] ? 'aria-current="page"' : '' !!}
                                >
                                    <span class="py-1 border-b-2 {{ isset($link['match']) && \Illuminate\Support\Str::of($currentPath)->start('/')->is($link['match']) ? 'border-gray-900' : 'border-transparent' }}">
                                        {{ $link['text'] }}
                                    </span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                    @isset($afterLinksDesktop)
                        {{ $afterLinksDesktop }}
                    @endif

                    @include('kernl-ui::includes.headers.search-desktop')
                </ul>
            </div>
        </div>
    </nav>
{{-- End light version --}}
@else
<nav
    aria-label="Site navigation"
    x-init="init"
    x-data="{
        navIsOpen: false,
        activeSection: null,
        focusableElements: [],
        init: function () {
            this.focusableElements = Array.from(this.$refs.desktopNav.querySelectorAll('a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), [tabindex=\'0\']'));
        },
        toggle: function (section) {
            if (this.activeSection === section) {
                return this.activeSection = null;
            }

            this.activeSection = section;
        },
        focusPreviousLink: function (event) {
            var index = this.focusableElements.indexOf(event.target);

            this.focusableElements[index - 1].focus();
        },
        focusNextLink: function (event, section = null) {
            if (section && this.activeSection !== section) {
                return this.activeSection = section;
            }

            var index = this.focusableElements.indexOf(event.target);

            this.focusableElements[index + 1].focus();
        }
    }"
    class="py-3 bg-gray-800"
    @keydown.window.escape="navIsOpen = false"
>
    <div class="mx-auto px-4 text-gray-50 lg:flex lg:items-center lg:justify-between lg:px-16">
        <div class="flex items-center justify-between">
            <a class="inline-block text-black focus:outline-none focus:ring focus:ring-blue-500" href="/">
                {{ $logo }}
            </a>
            <button class="ml-6 flex-shrink-0 lg:hidden focus:outline-none focus:ring focus:ring-blue-500" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" :aria-expanded="navIsOpen ? 'true' : 'false'" aria-label="Toggle navigation" @click="navIsOpen = ! navIsOpen">
                <svg aria-hidden="true" focusable="false" class="w-10 h-10 text-gray-200" viewBox="0 0 21 12" fill="none">
                    <g clip-path="url(#clip0)">
                        <path d="M20.35 10.13a.67.67 0 11-.96.92c-.8-.9-2.34-2.59-2.4-2.54a4.07 4.07 0 01-4.82.11 4.31 4.31 0 01-1.53-1.95 4.5 4.5 0 01.9-4.72 3.95 3.95 0 015.84 0 4.2 4.2 0 011.22 3.08c.01.9-.26 1.8-.77 2.54a36.2 36.2 0 002.52 2.56zm-7.9-2.98a2.77 2.77 0 003.14.65c.35-.15.67-.37.93-.65a2.87 2.87 0 00.85-2.12 3.12 3.12 0 00-.85-2.14A2.9 2.9 0 0014.47 2a2.67 2.67 0 00-2.04.89A2.96 2.96 0 0011.59 5a2.98 2.98 0 00.85 2.14zM.82 6.47c0-.37.3-.68.68-.68h5.24a.69.69 0 010 1.37H1.51a.69.69 0 01-.68-.69zm0-4.8c0-.38.3-.7.68-.7h5.9a.69.69 0 010 1.38h-5.9a.69.69 0 01-.68-.69zm0 9.6c0-.37.3-.68.68-.68h9.2a.69.69 0 110 1.37h-9.2a.69.69 0 01-.68-.68z" fill="currentColor" />
                    </g>
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div class="relative z-50" x-cloak>
            <div
                x-show="navIsOpen"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-black bg-opacity-75 transition-opacity lg:hidden"
                @click="navIsOpen = false"
            ></div>
            <div
                id="navbarContent"
                x-show="navIsOpen"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="fixed inset-y-0 left-0 transform px-4 pt-6 pb-16 bg-gray-800 overflow-y-auto transition-transform lg:hidden max-w-sm w-full"
            >
                <div class="flex items-start justify-between">
                    <a class="inline-block focus:outline-none focus:ring focus:ring-blue-500" href="/">
                        {{ $logo }}
                    </a>

                    <button class="ml-8 focus:outline-none focus:ring focus:ring-blue-500" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" :aria-expanded="navIsOpen ? 'true' : 'false'" aria-label="Close navigation" @click="navIsOpen = false">
                        <svg aria-hidden="true" focusable="false" class="w-6 h-6 text-gray-300" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <ul class="mt-8 w-full">
                    @include('kernl-ui::includes.headers.search-mobile')

                    @foreach ($links as $link)
                        <li class="block">
                            @isset($link['children'])
                                <a
                                    id="mobile-dropdown-{{ $loop->index }}"
                                    class="flex items-center justify-between py-4 whitespace-wrap border-b rounded-sm hover:bg-gray-700 focus:outline-none focus:ring focus:ring-blue-500"
                                    href="{{ $link['href'] }}"
                                    role="button" data-toggle="dropdown"
                                    aria-haspopup="true"
                                    :aria-expanded="activeSection === {{ $loop->index }} ? 'true' : 'false'"
                                    @keydown.space.prevent="toggle({{ $loop->index }})"
                                    @click.prevent="toggle({{ $loop->index }})" {!! $currentPath==$link['href'] ? 'aria-current="page"' : '' !!}
                                >
                                    {{ $link['text'] }}

                                    <svg aria-hidden="true" focusable="false" class="ml-2 w-4 h-4 text-gray-200" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </a>
                                <ul
                                    x-show="activeSection == {{ $loop->index }}"
                                    x-transition:enter="ease-out duration-300"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="ease-in duration-200"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    aria-labelledby="mobile-dropdown-{{ $loop->index }}"
                                >
                                    @foreach ($link['children'] as $child)
                                        <li class="relative border-b">
                                            <span aria-hidden class="absolute inset-y-0 left-0 ml-1 flex items-center text-gray-200 text-xl">&middot;</span>
                                            <a class="block py-4 pr-4 pl-6 hover:bg-gray-700 focus:outline-none focus:ring focus:ring-blue-500" href="{{ $child['href'] }}" {!! $currentPath==$child['href'] ? 'aria-current="page"' : '' !!} {!! \Illuminate\Support\Str::startsWith($link['href'], '#' ) ? '@click="navIsOpen = false"' : '' !!}>
                                                {{ $child['text'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <li class="block">
                                    <a class="inline-block w-full py-4 border-b rounded-sm hover:bg-gray-700 focus:outline-none focus:ring focus:ring-blue-500" href="{{ $link['href'] }}" {!! $currentPath==$link['href'] ? 'aria-current="page"' : '' !!} {!! \Illuminate\Support\Str::startsWith($link['href'], '#' ) ? '@click="navIsOpen = false"' : '' !!}>
                                        {{ $link['text'] }}
                                    </a>
                                </li>
                            @endif
                        </li>
                    @endforeach
                    @isset($afterLinksMobile)
                        {{ $afterLinksMobile }}
                    @endif
                </ul>
            </div>
        </div>

        <!-- Desktop Navigation -->
        <div x-ref="desktopNav" class="hidden lg:block">
            <ul class="-mx-2 flex items-center">
                @foreach ($links as $link)
                    @isset ($link['children'])
                        <li class="relative" @mouseenter="activeSection = {{ $loop->index }}" @mouseleave="activeSection = null">
                            <a id="navbar-dropdown-{{ $loop->index }}" class="inline-flex items-center px-4 py-3 text-sm rounded-sm hover:bg-gray-700 focus:outline-none focus:ring focus:ring-blue-500" href="{{ $link['href'] }}" role="button" data-toggle="dropdown" aria-haspopup="true" :aria-expanded="activeSection === {{ $loop->index }} ? 'true' : 'false'" @keydown.space.prevent="toggle({{ $loop->index }})" @keydown.enter.prevent="toggle({{ $loop->index }})" @keydown.arrow-down.prevent="focusNextLink($event, {{ $loop->index }})" {!! $currentPath==$link['href'] ? 'aria-current="page"' : '' !!}>
                                <span class="py-1 border-b-2 {{ isset($link['match']) && \Illuminate\Support\Str::of($currentPath)->start('/')->is($link['match']) ? 'border-gray-200' : 'border-transparent' }}">
                                    {{ $link['text'] }}
                                </span>

                                <svg aria-hidden="true" focusable="false" class="ml-2 w-4 h-4 text-gray-200" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </a>
                            <div
                                :class="{ 'flex': activeSection === {{ $loop->index }}, 'hidden': activeSection !== {{ $loop->index }} }"
                                aria-labelledby="navbar-dropdown-{{ $loop->index }}"
                                class="absolute right-0 top-0 z-10 w-64 mt-12 flex-col items-start justify-start py-2 bg-gray-800 shadow-sm rounded-sm"
                                x-cloak
                            >
                                @foreach ($link['children'] as $child)
                                    <a
                                        class="
                                            block w-full py-2 px-3 text-sm leading-tight transition-colors duration-200 hover:text-gray-50 focus:outline-none focus:ring focus:ring-blue-500
                                            {{ $currentPath === $child['href'] ? 'text-gray-50' : 'text-gray-200' }}
                                        "
                                        href="{{ $child['href'] }}"
                                        @keydown.arrow-up.prevent="focusPreviousLink"
                                        @unless($loop->last)
                                            @keydown.arrow-down.prevent="focusNextLink"
                                        @endif
                                        {!! $currentPath == $child['href'] ? 'aria-current="page"' : '' !!}
                                    >
                                        <span class="block w-full px-2 border-l-2 {{ $currentPath === $child['href'] ? 'border-gray-200' : 'border-transparent' }}">
                                            {{ $child['text'] }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </li>
                    @else
                        <li>
                            <a
                                class="inline-flex px-4 py-3 text-sm rounded-sm hover:bg-gray-700 focus:outline-none focus:ring focus:ring-blue-500"
                                href="{{ $link['href'] }}" {!! $currentPath==$link['href'] ? 'aria-current="page"' : '' !!}
                            >
                                <span
                                class="py-1 border-b-2 {{ isset($link['match']) && \Illuminate\Support\Str::of($currentPath)->start('/')->is($link['match']) ? 'border-gray-200' : 'border-transparent' }}">
                                    {{ $link['text'] }}
                                </span>
                            </a>
                        </li>
                    @endif
                @endforeach
                @isset($afterLinksDesktop)
                    {{ $afterLinksDesktop }}
                @endif

                @include('kernl-ui::includes.headers.search-desktop')
            </ul>
        </div>
    </div>
</nav>
@endif
