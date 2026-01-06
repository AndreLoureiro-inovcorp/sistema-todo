<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    task: Object
});

const form = useForm({
    title: props.task.title,
    description: props.task.description,
    due_date: props.task.due_date,
    priority: props.task.priority,
});

const submit = () => {
    form.put(route('tasks.update', props.task.id));
};

const deleteTask = () => {
    if (confirm('Tens a certeza que queres apagar esta task?')) {
        router.delete(route('tasks.destroy', props.task.id));
    }
};
</script>

<template>
    <Head title="Editar Task" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edita a Tarefa
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">
                                    Título *
                                </label>
                                <input
                                    id="title"
                                    v-model="form.title"
                                    type="text"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                    required
                                />
                                <div v-if="form.errors.title" class="text-red-600 text-sm mt-1">
                                    {{ form.errors.title }}
                                </div>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">
                                    Descrição
                                </label>
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                ></textarea>
                                <div v-if="form.errors.description" class="text-red-600 text-sm mt-1">
                                    {{ form.errors.description }}
                                </div>
                            </div>

                            <div>
                                <label for="due_date" class="block text-sm font-medium text-gray-700">
                                    Data de Vencimento
                                </label>
                                <input
                                    id="due_date"
                                    v-model="form.due_date"
                                    type="date"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                />
                                <div v-if="form.errors.due_date" class="text-red-600 text-sm mt-1">
                                    {{ form.errors.due_date }}
                                </div>
                            </div>

                            <div>
                                <label for="priority" class="block text-sm font-medium text-gray-700">
                                    Prioridade *
                                </label>
                                <select
                                    id="priority"
                                    v-model="form.priority"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                    required
                                >
                                    <option value="low">Baixa</option>
                                    <option value="medium">Média</option>
                                    <option value="high">Alta</option>
                                </select>
                                <div v-if="form.errors.priority" class="text-red-600 text-sm mt-1">
                                    {{ form.errors.priority }}
                                </div>
                            </div>

                            <div class="flex justify-between">
                                <div class="flex gap-4">
                                    <button
                                        type="submit"
                                        :disabled="form.processing"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
                                    >
                                        Confirmar
                                    </button>
                                    <Link
                                        :href="route('tasks.index')"
                                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                                    >
                                        Cancelar
                                    </Link>
                                </div>
                                <button
                                    type="button"
                                    @click="deleteTask"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                >
                                    Apagar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>