<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TaskFilters from '@/Components/Tasks/TaskFilters.vue';
import TaskCard from '@/Components/Tasks/TaskCard.vue';
import { Head, Link } from '@inertiajs/vue3';
import TaskDetailsModal from '@/Components/Tasks/TaskDetailsModal.vue';
import { ref } from 'vue';

defineProps({
    tasks: Array,
    filters: Object
});

const showModal = ref(false);
const selectedTask = ref(null);

const showTaskDetails = (task) => {
    selectedTask.value = task;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    selectedTask.value = null;
};

</script>

<template>

    <Head title="As Minhas Tarefas" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    As Minhas Tarefas
                </h2>
                <Link :href="route('tasks.create')"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                    Nova Tarefa
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <TaskFilters :current-status="filters?.status || 'all'" :current-priority="filters?.priority || 'all'"
                    :current-date-filter="filters?.date_filter || 'all'" />

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div v-if="tasks.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <TaskCard v-for="task in tasks" :key="task.id" :task="task"
                                @show-details="showTaskDetails" />
                        </div>

                        <div v-else class="text-center py-12">
                            <p class="text-gray-500 text-lg mb-4">
                                Não tens tarefas com estes filtros.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <TaskDetailsModal :show="showModal" :task="selectedTask" @close="closeModal" />
    </AuthenticatedLayout>
</template>