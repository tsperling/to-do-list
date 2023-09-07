<template>
    <div class="row">
        <div class="col-lg-4">
            <form class="form-taskinput">
                <label for="inputTaskName" class="sr-only">Task name</label>
                <input type="text" id="inputTaskName" class="form-control" placeholder="Insert task name" required="" autofocus="" v-model="newTaskText">
                <button class="btn btn-primary btn-block" type="submit" @click="createTask">Add</button>
            </form>
        </div>
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table id="taskTable" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th colspan="2">Task</th>
                            </tr>
                        </thead>
                        <tbody v-if="taskArray.length > 0">
                            <tr v-for="(task) in taskArray" :key="task.id" :class="`${task.completed ? 'completed' : ''}`">
                                <td>{{ task.id }}</td>
                                <td>{{ task.text }}</td>
                                <td>
                                    <div v-if="(!task.completed)">
                                        <button type="button" class="btn btn-success" @click="completeTask(task.id)">
                                            <span class="glyphicon glyphicon-ok"></span>
                                        </button>
                                        <button type="button" class="btn btn-danger" @click="deleteTask(task.id)">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="3">There are currently no tasks to display</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {ref, onMounted} from 'vue'

export default {
    setup() {
        const newTaskText = ref('');
        const taskArray = ref([]);

        onMounted(() => {
            getTasks()
        });

        /**
         * Get all the tasks from the DB
         * Could be improved by pagination?
         */
        const getTasks = () => {
            axios.get('/api/get-tasks')
            .then(response => {
                taskArray.value = response.data.data
            })
            .catch(e => {
                console.log(e);
            })
        }

        /**
         * Creating a new task
         * Laravel request validation used on the backend
         */
        const createTask = () => {
            if (newTaskText.value !== "") {
                const taskData = {text: newTaskText.value};
                axios.post('/api/create-task', taskData)
                .then(response => {
                    taskArray.value.push(response.data.data);
                })
                .catch(e => displayError(e));
            }
            // Reset the input text to allow a new task to be created
            newTaskText.value = "";
        }

        /**
         * Updating a task's completed property
         */
        const completeTask = async (id) => {
            axios.post('/api/complete-task', {id})
            .then(response => {
                taskArray.value.find(task => task.id === id).completed = true;
            })
            .catch(e => displayError(e));
        }

        /**
         * Deleting a task
         * Soft deletes are used in the Task model, so this is reversible if needed
         */
        const deleteTask = async (id) => {
            if (window.confirm("Please confirm that you wish to delete this task")) {
                axios.post('/api/delete-task', {id})
                .then(response => {
                    console.log(taskArray.value.find(task => task.id === id));
                    taskArray.value.splice(taskArray.value.findIndex(task => task.id === id), 1);
                })
                .catch(e => displayError(e));
            }
        }

        /**
         * Very basic error msg display
         */
        const displayError = (e) => {
            console.log(e);
            alert(e.response?.data?.message);
        }

        return {
            newTaskText,
            taskArray,
            completeTask,
            createTask,
            deleteTask,
        }
    },
}
</script>
