<x-app-layout>
    <x-slot name="pageTitle">Dashboard</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Hallo und herzlich Willkommen..
                    </div>

                    <div class="mt-6 text-gray-500">
                        .. beim Manager. Manager ist eine simple Anwendung zur Verwaltung von verschiedenen Informationen.
                        Manager befindet sich in einer frühen Phase und enthält bisher nur die Funktionalität der Verwaltung von virtuellen Bankkonten.
                        Auf <a href="https://github.com/elyday/manager" target="_blank">GitHub</a> kannst du die Entwicklung von Manager verfolgen
                        und <a href="https://github.com/elyday/manager/milestones" target="_blank">hier</a> findest du zudem unsere Roadmap.
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>