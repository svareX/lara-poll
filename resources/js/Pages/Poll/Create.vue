<template>
    <Head title="Create a new poll" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create a new poll</h2>
        </template>
        <div>
            <form @submit.prevent="submit" class="m-10">
                <div class="flex flex-col md:flex-row gap-4 mb-8">
                    <div class="w-full md:w-5/12">
                        <InputLabel for="title" value="Title" />
                        <TextInput
                            id="title"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.title"
                            required
                            autofocus
                            placeholder="Who's the best?"
                            autocomplete="title"
                        />
                        <InputError class="mt-2" :message="form.errors.title" />
                    </div>

                    <div class="w-full md:w-5/12">
                        <InputLabel for="ends_at" value="Poll ends at" />
                        <TextInput id="ends_at"
                            type="datetime-local"
                            class="mt-1 block w-full"
                            v-model="form.ends_at"
                            required
                            autofocus
                            autocomplete="ends_at"/>
                        <InputError class="mt-2" :message="form.errors.ends_at"/>
                    </div>

                    <div class="w-full md:w-2/12">
                        <InputLabel for="options_count" value="Number of poll options" />
                        <TextInput
                            id="options_count"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.option_count"
                            min="2"
                            max="10"
                            required
                            autofocus
                            autocomplete="options_count"
                        />
                        <InputError class="mt-2" :message="form.errors.options_count" />
                    </div>
                </div>

                <div v-for="index in Number(form.option_count)" class="flex flex-col md:flex-row gap-4 mb-4">
                    <div class="w-full md:w-11/5">
                        <InputLabel :for="'option_title_'+index" :value="'Poll option title #'+index" />
                        <TextInput
                            :id="'option_title_'+index"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form['option_title'+index]"
                            required
                            autofocus
                            :placeholder="Math.random()<0.5 ? 'Me' : 'You'"
                            :autocomplete="'option_title_'+index"
                        />
                    </div>
                    <div class="w-full md:w-1/12 flex flex-col justify-end">
                        <vueticol v-model="form['option_color'+index]" :colors="colors"/>
                    </div>
                </div>

                <div class="flex justify-center md:justify-end items-center gap-4">
                    <button type="submit" class="bg-violet-500 dark:bg-indigo-700 hover:bg-violet-600 dark:hover:bg-indigo-600 font-medium p-3 rounded-md w-24">Create</button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import TextInput from '@/Components/TextInput.vue'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'

const now = new Date();
now.setMinutes(now.getMinutes() - now.getTimezoneOffset());

function submit() {
    form.post(route('polls.store'))
}
const colors = [
    "#4f0000", "#960606", "#c90808", "#fa0000", "#eb4b4b", //red
    "#ff6600", "#ff8c00", "#ffbf00", "#ffd966", "#ffe699", //orange
    "#f2ff00", "#a6ff00", "#51ff00", "#14c72f", "#126e1f", //green
    "#00eeff", "#00aeff", "#007bff", "#0037ff", "#3700ff", //blue
    "#5505ab", "#a600ff", "#d000ff", "#fb00ff", "#ff00c8", //purple
    "#5c3015", "#75340c", "#730202", "#ffffff", "#121211", //brown + white + black
]

const form = useForm({
    title: null,
    ends_at: now.toISOString().slice(0, 16),
    option_count: 2,
    option_title1: null,
    option_color1: null,
    option_title2: null,
    option_color2: null,
    option_title3: null,
    option_color3: null,
    option_title4: null,
    option_color4: null,
    option_title5: null,
    option_color5: null,
    option_title6: null,
    option_color6: null,
    option_title7: null,
    option_color7: null,
    option_title8: null,
    option_color8: null,
    option_title9: null,
    option_color9: null,
    option_title10: null,
    option_color10: null,
});
</script>

