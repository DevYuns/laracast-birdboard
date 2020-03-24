<template>
    <modal name="new-project-modal" classes="p-10 bg-card rounded-lg" height="auto">
        <h1 class="font-normal mb-16 text-center text-2xl theme-light">
            Let's Start Something New
        </h1>

        <form @submit.prevent="submit">
            <div class="flex">
                <div class="flex-1 mr-4">
                    <div class="mb-4">
                        <label for="title" class="font-bold text-sm block mb-2">
                            Title
                        </label>
                        <input
                            type="text"
                            id="title"
                            class="border p-2 text-xs block w-full rounded"
                            :class="form.errors.title ? 'border-error' : 'border-muted'"
                            v-model="form.title"
                        />
                        <span
                            class="text-xs italic text-error"
                            v-if="form.errors.title"
                            v-text="form.errors.title[0]"></span>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="font-bold text-sm block mb-2">
                            Description
                        </label>
                        <textarea
                            id="description"
                            class="border p-2 text-xs block w-full rounded"
                            :class="form.errors.description ? 'border-error' : 'border-muted'"
                            rows="7"
                            v-model="form.description">
                    </textarea>
                        <span
                            class="text-xs italic text-error"
                            v-if="form.errors.description"
                            v-text="form.errors.description[0]"></span>
                    </div>
                </div>

                <div class="flex-1 mr-4">
                    <div class="mb-4">
                        <label class="text-sm font-bold  block mb-2">
                            Need some tasks?
                        </label>
                        <input
                            type="text"
                            class="border border-muted-light p-2 text-xs block w-full rounded mb-2"
                            placeholder="Task 1"
                            v-for="task in form.tasks"
                            v-model="task.body"
                        />
                    </div>

                    <button type="button" class="inline-flex items-center" @click="addTask">
                        <img src="/images/plus.png" class="opacity-50 mr-2" width="16" height="16" />
                        <span class="text-xs">
                        Add New Task Field
                        </span>
                    </button>

                </div>
            </div>

            <footer class="flex justify-end">
                <button type="button" class="button is-outlined mr-4" @click="$modal.hide('new-project-modal')">
                    Cancel
                </button>
                <button type="submit" class="button">
                    Create Project
                </button>
            </footer>
        </form>
    </modal>
</template>

<script>
    import BirdboardForm from './BirdboardForm';
    export default {
        data() {
            return {
                form: new BirdboardForm ({
                    title : '',
                    description : '',
                    tasks : [
                        {body : ''},
                    ]
                })
            }
        },
        methods: {
            addTask() {
                this.form.tasks.push({body : ''});
            },

            async submit() {
                if (! this.form.tasks[0].body) {
                    delete this.form.originalData.tasks;
                }

                this.form.submit('/projects')
                    .then(response => location = response.data.message);
                // try {
                //     location = (await axios.post('/projects', this.form)).data.message;
                // } catch (error) {
                //     this.errors = error.response.data.errors;
                // }
            }
        }
    }
</script>
