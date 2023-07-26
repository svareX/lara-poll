<template>
    <Head :title="'Edititing the \''+ poll.title + '\' poll'" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit the '{{ poll.title }}' poll</h2>
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
                    <div class="w-full md:w-4/5">
                        <InputLabel :for="'option_title_'+index" :value="'Poll option title #'+index" />
                        <TextInput
                            :id="'option_title_'+index"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form['option_title'+index]"
                            required
                            autofocus
                            :autocomplete="'option_title_'+index"
                        />
                    </div>
                    <div class="w-full md:w-1/5">
                        <InputLabel :for="'option_color'+index" :value="'Poll option color #'+index" />
                        <TextInput
                            :id="'option_color'+index"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form['option_color'+index]"
                            required
                            autofocus
                            :autocomplete="'option_color'+index"
                        />
                    </div>
                </div>

                <div class="flex justify-center md:justify-end items-center gap-4">
                    <button type="submit" class="bg-violet-500 dark:bg-indigo-700 hover:bg-violet-600 dark:hover:bg-indigo-600 font-medium p-3 rounded-md w-24">Update</button>
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

const props = defineProps({
    poll: Object,
})

const form = useForm({
    title: props.poll.title ?? 'Poll title',
    ends_at: props.poll.ends_at ?? now.toISOString().slice(0,16),
    option_count: props.poll.options_count ?? 2,
    option_title1: null,
    option_color1: '#7e22ce',
    option_title2: null,
    option_color2: '#7e22ce',
    option_title3: null,
    option_color3: '#7e22ce',
    option_title4: null,
    option_color4: '#7e22ce',
    option_title5: null,
    option_color5: '#7e22ce',
    option_title6: null,
    option_color6: '#7e22ce',
    option_title7: null,
    option_color7: '#7e22ce',
    option_title8: null,
    option_color8: '#7e22ce',
    option_title9: null,
    option_color9: '#7e22ce',
    option_title10: null,
    option_color10: '#7e22ce',
});
props.poll.options.forEach((option, index) => {
    form['option_title'+(index+1)] = option.title
    form['option_color'+(index+1)] = option.color
});

function submit() {
    form.put(route('polls.update', props.poll.id))
}
</script>
