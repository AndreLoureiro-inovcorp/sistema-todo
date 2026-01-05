<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>

    <Head title="Welcome" />

    <div
        class="relative min-h-screen bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 selection:bg-[#FF2D20] selection:text-white">
        <img id="background" class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg" alt="" />

        <div class="relative mx-auto w-full max-w-7xl px-6 flex flex-col min-h-screen">

            <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                <div class="flex lg:col-start-2 lg:justify-center">
                    <svg class="h-12 w-auto text-white lg:h-16 lg:text-[#FF2D20]" viewBox="0 0 62 65" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M61.8548 14.6253C61.8778 14.7102..." fill="currentColor" />
                    </svg>
                </div>

                <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Dashboard
                    </Link>

                    <template v-else>
                        <Link :href="route('login')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Log in
                        </Link>

                        <Link v-if="canRegister" :href="route('register')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Register
                        </Link>
                    </template>
                </nav>
            </header>

            <main class="flex-1 mt-20 text-center">
                <h1 class="text-5xl font-bold text-black dark:text-white mb-6">
                    Aplicação para Gestão de Tarefas
                </h1>

                <p class="text-xl text-gray-600 dark:text-gray-400 mb-12 max-w-2xl mx-auto mt-4">
                    Organiza, prioriza e conclui as tuas tarefas de forma simples e eficiente!
                </p>

                <div class="grid gap-6 md:grid-cols-3 max-w-4xl mx-auto text-left">
                    <div class="bg-white dark:bg-zinc-900 rounded-lg p-6 shadow-lg">
                        <h3 class="font-semibold text-black dark:text-white mb-2 text-lg">
                            Gestão Completa
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Cria, edita, elimina e marca as tarefas como concluídas
                        </p>
                    </div>

                    <div class="bg-white dark:bg-zinc-900 rounded-lg p-6 shadow-lg">
                        <h3 class="font-semibold text-black dark:text-white mb-2 text-lg">
                            Filtros Inteligentes
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Filtra por estado, prioridade e data de conclusão
                        </p>
                    </div>

                    <div class="bg-white dark:bg-zinc-900 rounded-lg p-6 shadow-lg">
                        <h3 class="font-semibold text-black dark:text-white mb-2 text-lg">
                            Totalmente Responsivo
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            A Apllicação funciona perfeitamente em computador, tablet e telemóvel
                        </p>
                    </div>
                </div>
            </main>

            <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                Desenvolvido com Laravel {{ laravelVersion }} + Vue 3 + Tailwind CSS
            </footer>

        </div>
    </div>
</template>
