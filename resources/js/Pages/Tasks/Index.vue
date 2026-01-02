<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    tasks: Array,
    filters: Object
});
</script>

<template>
    <Head title="Minhas Tasks" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    As minhas Tarefas
                </h2>
                <Link 
                    :href="route('tasks.create')"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                >
                    Nova Tarefa
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div v-if="tasks.length > 0" class="space-y-4">
                            <div 
                                v-for="task in tasks" 
                                :key="task.id"
                                class="border p-4 rounded"
                            >
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold">
                                            {{ task.title }}
                                        </h3>
                                        <p v-if="task.description" class="text-gray-600 mt-1">
                                            {{ task.description }}
                                        </p>
                                        <div class="mt-2 flex gap-2">
                                            <span 
                                                class="text-xs px-2 py-1 rounded"
                                                :class="{
                                                    'bg-red-100 text-red-800': task.priority === 'high',
                                                    'bg-yellow-100 text-yellow-800': task.priority === 'medium',
                                                    'bg-green-100 text-green-800': task.priority === 'low'
                                                }"
                                            >
                                                {{ task.priority }}
                                            </span>
                                            <span 
                                                v-if="task.is_completed"
                                                class="text-xs px-2 py-1 rounded bg-green-100 text-green-800"
                                            >
                                                Concluída
                                            </span>
                                            <span 
                                                v-else
                                                class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-800"
                                            >
                                                Pendente
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <Link 
                                            :href="route('tasks.edit', task.id)"
                                            class="text-blue-600 hover:text-blue-800"
                                        >
                                            Editar
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-center py-8 text-gray-500">
                            Ainda não tens tasks. Cria a tua primeira!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>