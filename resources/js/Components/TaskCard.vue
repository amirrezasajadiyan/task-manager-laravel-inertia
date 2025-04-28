<template>
  <div class="bg-white p-4 rounded-lg shadow mb-4">
    <div class="flex justify-between items-start">
      <div>
        <h3 class="text-lg font-semibold">{{ task.title }}</h3>
        <p class="text-gray-600 mt-1">{{ task.description }}</p>
        <div class="mt-2 flex items-center space-x-2">
          <p class="text-sm text-gray-500">
            Due: {{ task.due_date ? new Date(task.due_date).toLocaleDateString() : 'No due date' }}
          </p>
          <span
            :class="[
              'px-2 py-1 text-xs rounded-full',
              statusColors[task.status]
            ]"
          >
            {{ formatStatus(task.status) }}
          </span>
        </div>
      </div>
      <div class="flex space-x-2">
        <button
          @click="$emit('edit', task)"
          class="text-blue-500 hover:text-blue-700 p-1 rounded-full hover:bg-blue-50"
          title="Edit Task"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
          </svg>
        </button>
        <button
          @click="$emit('delete', task.id)"
          class="text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-50"
          title="Delete Task"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>
        </button>
      </div>
    </div>

    <div class="mt-4">
      <div class="flex items-center justify-between mb-2">
        <h4 class="text-sm font-medium text-gray-700">Subtasks</h4>
        <button
          @click="showAddSubtask = !showAddSubtask"
          class="text-sm text-green-600 hover:text-green-800"
        >
          + Add Subtask
        </button>
      </div>

      <div v-if="showAddSubtask" class="mb-4">
        <div class="flex gap-2">
          <input
            v-model="newSubtaskTitle"
            @keyup.enter="addSubtask"
            type="text"
            class="flex-1 px-3 py-2 border rounded-md"
            placeholder="Enter subtask title"
          />
          <button
            @click="addSubtask"
            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            Add
          </button>
        </div>
      </div>

      <div class="space-y-2">
        <div
          v-for="subtask in task.subtasks"
          :key="subtask.id"
          class="flex items-center justify-between p-2 bg-gray-50 rounded"
        >
          <div class="flex items-center">
            <input
              type="checkbox"
              :checked="subtask.is_completed"
              @change="updateSubtaskStatus(subtask)"
              class="h-4 w-4 text-blue-600 rounded border-gray-300"
            />
            <span
              :class="[
                'ml-3',
                subtask.is_completed ? 'line-through text-gray-500' : 'text-gray-700'
              ]"
            >
              {{ subtask.title }}
            </span>
          </div>
          <button
            @click="$emit('delete-subtask', subtask.id)"
            class="text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-50"
            title="Delete Subtask"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  task: {
    type: Object,
    required: true
  }
});

const showAddSubtask = ref(false);
const newSubtaskTitle = ref('');

const statusColors = {
  todo: 'bg-gray-100 text-gray-800',
  in_progress: 'bg-yellow-100 text-yellow-800',
  done: 'bg-green-100 text-green-800',
};

const formatStatus = (status) => {
  return status.split('_').map(word => 
    word.charAt(0).toUpperCase() + word.slice(1)
  ).join(' ');
};

const addSubtask = () => {
  if (newSubtaskTitle.value.trim()) {
    emit('add-subtask', props.task.id, newSubtaskTitle.value);
    newSubtaskTitle.value = '';
    showAddSubtask.value = false;
  }
};

const updateSubtaskStatus = (subtask) => {
  emit('update-subtask', subtask.id, {
    is_completed: !subtask.is_completed
  });
};

const emit = defineEmits(['edit', 'delete', 'add-subtask', 'update-subtask', 'delete-subtask']);
</script> 