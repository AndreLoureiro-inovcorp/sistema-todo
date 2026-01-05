<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    task: {
        type: Object,
        default: null
    }
})

const emit = defineEmits(['close'])

const closeModal = () => {
    emit('close')
}

const formatDate = (dateString) => {
    if (!dateString) return '—'
    return new Date(dateString).toLocaleDateString('pt-PT', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    })
}

const getPriorityLabel = (priority) => {
    return {
        high: 'Alta',
        medium: 'Média',
        low: 'Baixa'
    }[priority] || priority
}

const getPriorityColor = (priority) => {
    return {
        high: 'bg-red-100 text-red-800 border-red-300',
        medium: 'bg-yellow-100 text-yellow-800 border-yellow-300',
        low: 'bg-green-100 text-green-800 border-green-300'
    }[priority] || 'bg-gray-100 text-gray-800'
}
</script>


<template>
    <Transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0"
        enter-to-class="opacity-100" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100"
        leave-to-class="opacity-0">
        <div v-if="show && task" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40" @click="closeModal" />
    </Transition>

    <Transition enter-active-class="transition ease-out duration-200"
        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="transition ease-in duration-150"
        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        <div v-if="show && task" class="fixed inset-0 z-50 overflow-y-auto" @click="closeModal">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative bg-white rounded-lg shadow-xl
                           max-w-2xl w-full
                           max-h-[90vh] overflow-y-auto
                           p-6 sm:p-8" @click.stop>
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 leading-snug"
                            :class="{ 'line-through text-gray-500': task.is_completed }">
                            {{ task.title }}
                        </h2>

                        <button @click="closeModal" class="text-gray-400 hover:text-gray-600 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="mb-8">
                        <p v-if="task.description" class="text-gray-700 whitespace-pre-wrap leading-relaxed"
                            :class="{ 'line-through text-gray-500': task.is_completed }">
                            {{ task.description }}
                        </p>
                        <p v-else class="text-gray-400 italic">
                            Sem descrição
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                        <div class="space-y-2">
                            <p class="text-sm text-gray-500">Prioridade</p>
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium border"
                                :class="getPriorityColor(task.priority)">
                                {{ getPriorityLabel(task.priority) }}
                            </span>
                        </div>

                        <div class="space-y-2">
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium" :class="task.is_completed
                                ? 'bg-green-100 text-green-800'
                                : 'bg-gray-100 text-gray-800'">
                                {{ task.is_completed ? 'Concluída' : 'Por fazer' }}
                            </span>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Criada em:</p>
                                <p class="text-gray-700">{{ formatDate(task.created_at) }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Ultimo dia:</p>
                                <p class="text-gray-700">
                                    {{ task.due_date ? formatDate(task.due_date) : 'Sem prazo definido' }}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>
