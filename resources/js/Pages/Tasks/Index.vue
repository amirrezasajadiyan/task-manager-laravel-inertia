<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasks</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="flex justify-between items-center mb-6">
              <div class="flex space-x-4">
                <button
                  @click="filterStatus = null"
                  :class="[
                    'px-4 py-2 rounded',
                    !filterStatus ? 'bg-blue-500 text-white' : 'bg-gray-200'
                  ]"
                >
                  All
                </button>
                <button
                  @click="filterStatus = 'todo'"
                  :class="[
                    'px-4 py-2 rounded',
                    filterStatus === 'todo' ? 'bg-blue-500 text-white' : 'bg-gray-200'
                  ]"
                >
                  Todo
                </button>
                <button
                  @click="filterStatus = 'in_progress'"
                  :class="[
                    'px-4 py-2 rounded',
                    filterStatus === 'in_progress' ? 'bg-blue-500 text-white' : 'bg-gray-200'
                  ]"
                >
                  In Progress
                </button>
                <button
                  @click="filterStatus = 'done'"
                  :class="[
                    'px-4 py-2 rounded',
                    filterStatus === 'done' ? 'bg-blue-500 text-white' : 'bg-gray-200'
                  ]"
                >
                  Done
                </button>
              </div>
              <button
                @click="showTaskModal = true"
                class="bg-green-500 text-white px-4 py-2 rounded"
              >
                New Task
              </button>
            </div>

            <div class="space-y-4">
              <TaskCard
                v-for="task in tasks"
                :key="task.id"
                :task="task"
                @edit="editTask"
                @delete="deleteTask"
                @add-subtask="addSubtask"
                @update-subtask="updateSubtask"
                @delete-subtask="deleteSubtask"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <TaskModal
      v-if="showTaskModal"
      :task="editingTask"
      @close="closeModal"
      @save="saveTask"
    />
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TaskCard from '@/Components/TaskCard.vue';
import TaskModal from '@/Components/TaskModal.vue';

const props = defineProps({
  tasks: Array,
  status: String,
});

const filterStatus = ref(props.status);
const showTaskModal = ref(false);
const editingTask = ref(null);

watch(filterStatus, (newStatus) => {
  
  router.get(route('tasks.index'), { 
    status: newStatus === null ? '' : newStatus 
  }, {
    preserveState: true,
    preserveScroll: true,
  });
});

const editTask = (task) => {
  editingTask.value = task;
  showTaskModal.value = true;
};

const closeModal = () => {
  showTaskModal.value = false;
  editingTask.value = null;
};

const saveTask = (taskData) => {
  if (taskData.id) {
    router.put(route('tasks.update', taskData.id), taskData, {
      onSuccess: () => {
        closeModal();
      },
    });
  } else {
    router.post(route('tasks.store'), taskData, {
      onSuccess: () => {
        closeModal();
      },
    });
  }
};

const deleteTask = (taskId) => {
  if (confirm('Are you sure you want to delete this task?')) {
    router.delete(route('tasks.destroy', taskId));
  }
};

const addSubtask = (taskId, title) => {
  router.post(route('tasks.subtasks.store', taskId), { title });
};

const updateSubtask = (subtaskId, data) => {
  router.put(route('subtasks.update', subtaskId), data);
};

const deleteSubtask = (subtaskId) => {
  router.delete(route('subtasks.destroy', subtaskId));
};
</script> 