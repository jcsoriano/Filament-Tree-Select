@php
    use Filament\Support\Facades\FilamentAsset;
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    @push('styles')
        <style>
            .select-item:hover {
                background: #2f2f2f;
            }

            #options .fi-section-content {
                padding: 0 !important;
            }
        </style>
    @endpush

    <div
        x-data="setup(
            $wire.$entangle('{{ $getStatePath() }}'),
            @js($options()),
            @js($searchItems()),
            @js($getLabelAttribute()),
        )"
    >
        <div @click.outside="clickOutsideClose">
            <div class="relative">
                <x-filament::input.wrapper :disabled="$isDisabled()">
                    <x-filament::input type="text" x-model="searchQuery" @focus="showOptions = true" :disabled="$isDisabled()" />
                </x-filament::input.wrapper>

                <x-filament::section x-show="showOptions" id="options" class="absolute w-full z-10 mt-1 max-h-60 overflow-auto" style="max-height: 250px; overflow-y: auto; bottom: 43px">
                    <ul x-show="! searchQuery" class="py-1 text-base sm:text-sm" role="listbox">
                        <template x-for="optionItem in options">
                            <li class="relative cursor-default select-none text-gray-900" role="option">
                                <label class="select-item flex cursor-pointer py-2 px-3">
                                    <input class="hidden" type="checkbox" :value="optionItem.id" @change="toggle(optionItem)">
                                    <span class="ml-3 truncate" x-text="optionItem[labelAttribute]"></span>
                                    <span x-show="!!state.find(item => item.id === optionItem.id)" class="text-indigo-600 ml-auto">
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </label>

                                <ul x-show="optionItem.children.length" class="mt-1 w-full text-base pl-6 focus:outline-none sm:text-sm" role="listbox" style="padding-left: 2rem">
                                    <template x-for="child in optionItem.children">
                                        <li class="relative cursor-default select-none text-gray-900" role="option">
                                            <label class="select-item flex cursor-pointer py-2 px-3">
                                                <input class="hidden" type="checkbox" :value="child.id" @change="toggle(child)">
                                                <span class="ml-3 truncate" x-text="child[labelAttribute]"></span>
                                                <span x-show="!!state.find(item => item.id === child.id)" class="text-indigo-600 ml-auto">
                                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </label>

                                            <ul x-show="child.children.length" class="mt-1 w-full text-base focus:outline-none sm:text-sm" role="listbox" style="padding-left: 2rem">
                                                <template x-for="grandchild in child.children">
                                                    <li class="relative cursor-default select-none text-gray-900" role="option">
                                                        <label class="select-item flex cursor-pointer py-2 px-3">
                                                            <input class="hidden" type="checkbox" :value="grandchild.id" @change="toggle(grandchild)">
                                                            <span class="ml-3 truncate" x-text="grandchild[labelAttribute]"></span>
                                                            <span x-show="!!state.find(item => item.id === grandchild.id)" class="text-indigo-600 ml-auto">
                                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                                                </svg>
                                                            </span>
                                                        </label>
                                                    </li>
                                                </template>
                                            </ul>
                                        </li>
                                    </template>
                                </ul>
                            </li>
                        </template>
                    </ul>

                    <ul x-show="searchQuery && searchResults().length" class="py-1 text-base sm:text-sm" role="listbox">
                        <template x-for="result in searchResults()">
                            <li class="relative cursor-default select-none text-gray-900" role="option">
                                <label class="block select-item py-2 px-3 cursor-pointer">
                                    <div class="flex">
                                        <input class="hidden" type="checkbox" :value="result.id" @change="toggle(result)">
                                        <span class="ml-3 truncate" x-html="result[labelAttribute]"></span>
                                        <span x-show="!!state.find(item => item.id === result.id)" class="text-indigo-600 ml-auto">
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div x-show="result.breadcrumbs" class="text-sm text-gray-500">
                                        <span x-text="result.breadcrumbs"></span>
                                    </div>
                                </label>
                            </li>
                        </template>
                    </ul>
                </x-filament::section>
            </div>

            <div x-show="state.length" class="flex items-center flex-wrap gap-1 mt-2">
                <template x-for="item in state">
                    <x-filament::badge x-text="item[labelAttribute]"></x-filament::badge>
                </template>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ FilamentAsset::getAlpineComponentSrc('filament-tree-select', package: 'magissolutions/filament-tree-select') }}"></script>
    @endpush
</x-dynamic-component>
