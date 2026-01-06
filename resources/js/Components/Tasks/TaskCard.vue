<script setup>
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    task: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['showDetails']);

const toggleComplete = () => {
    router.patch(route('tasks.toggle', props.task.id), {}, {
        preserveScroll: true,
    });
};

const formatDate = (dateString) => {
    if (!dateString) return null;
    const date = new Date(dateString);
    return date.toLocaleDateString('pt-PT', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
};

const getPriorityLabel = (priority) => {
    const labels = {
        high: 'Alta',
        medium: 'Média',
        low: 'Baixa'
    };
    return labels[priority] || priority;
};
</script>

<template>
    <div class="border rounded-lg p-4 hover:shadow-lg transition cursor-pointer"
        :class="{ 'opacity-60 bg-gray-50': task.is_completed }" @click="emit('showDetails', task)">
        <div class="flex items-start gap-3 mb-3">
            <input type="checkbox" :checked="task.is_completed" @change="toggleComplete" @click.stop
                @keydown.enter.prevent="toggleComplete" @keydown.space.prevent="toggleComplete" tabindex="0"
                class="mt-1 w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" />
            <h3 class="text-lg font-semibold flex-1" :class="{ 'line-through text-gray-500': task.is_completed }">
                {{ task.title }}
            </h3>
        </div>

        <p v-if="task.description" class="text-gray-600 text-sm mb-3 line-clamp-2"
            :class="{ 'line-through': task.is_completed }">
            {{ task.description }}
        </p>

        <div class="flex flex-wrap gap-2 mb-3">
            <span class="text-xs px-2 py-1 rounded font-medium" :class="{
                'bg-red-100 text-red-800': task.priority === 'high',
                'bg-yellow-100 text-yellow-800': task.priority === 'medium',
                'bg-green-100 text-green-800': task.priority === 'low'
            }">
                {{ getPriorityLabel(task.priority) }}
            </span>
            <span v-if="task.due_date" class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-700">
                Ultimo dia: {{ formatDate(task.due_date) }}
            </span>
        </div>

        <div class="pt-3 border-t">
            <Link :href="route('tasks.edit', task.id)" class="text-blue-600 hover:text-blue-800 font-medium text-sm"
                @click.stop>
                Editar
            </Link>
        </div>
    </div>
</template>