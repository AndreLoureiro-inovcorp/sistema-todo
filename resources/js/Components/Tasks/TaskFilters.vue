<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    currentStatus: {
        type: String,
        default: 'all'
    },
    currentPriority: {
        type: String,
        default: 'all'
    }
});

const statusFilter = ref(props.currentStatus);
const priorityFilter = ref(props.currentPriority);

const applyFilters = () => {
    const params = {};

    if (statusFilter.value !== 'all') {
        params.status = statusFilter.value;
    }

    if (priorityFilter.value !== 'all') {
        params.priority = priorityFilter.value;
    }

    router.get(route('tasks.index'), params, {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
        <div class="p-4">
            <div class="flex flex-col md:flex-row md:items-center gap-4">

                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                    <span class="text-sm font-medium text-gray-700">Status:</span>
                    <div class="flex flex-wrap gap-1">
                        <button @click="statusFilter = 'all'; applyFilters()" :class="[
                            'px-3 py-1 rounded text-sm transition',
                            statusFilter === 'all'
                                ? 'bg-blue-500 text-white'
                                : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                        ]">
                            Todas
                        </button>
                        <button @click="statusFilter = 'pending'; applyFilters()" :class="[
                            'px-3 py-1 rounded text-sm transition',
                            statusFilter === 'pending'
                                ? 'bg-blue-500 text-white'
                                : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                        ]">
                            Pendentes
                        </button>
                        <button @click="statusFilter = 'completed'; applyFilters()" :class="[
                            'px-3 py-1 rounded text-sm transition',
                            statusFilter === 'completed'
                                ? 'bg-blue-500 text-white'
                                : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                        ]">
                            Concluídas
                        </button>
                    </div>
                </div>

                <div class="hidden md:block h-6 w-px bg-gray-300"></div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                    <span class="text-sm font-medium text-gray-700">Prioridade:</span>
                    <div class="flex flex-wrap gap-1">
                        <button @click="priorityFilter = 'all'; applyFilters()" :class="[
                            'px-3 py-1 rounded text-sm transition',
                            priorityFilter === 'all'
                                ? 'bg-blue-500 text-white'
                                : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                        ]">
                            Todas
                        </button>
                        <button @click="priorityFilter = 'high'; applyFilters()" :class="[
                            'px-3 py-1 rounded text-sm transition',
                            priorityFilter === 'high'
                                ? 'bg-red-500 text-white'
                                : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                        ]">
                            Alta
                        </button>
                        <button @click="priorityFilter = 'medium'; applyFilters()" :class="[
                            'px-3 py-1 rounded text-sm transition',
                            priorityFilter === 'medium'
                                ? 'bg-yellow-500 text-white'
                                : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                        ]">
                            Média
                        </button>
                        <button @click="priorityFilter = 'low'; applyFilters()" :class="[
                            'px-3 py-1 rounded text-sm transition',
                            priorityFilter === 'low'
                                ? 'bg-green-500 text-white'
                                : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                        ]">
                            Baixa
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>