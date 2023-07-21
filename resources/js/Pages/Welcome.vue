<script setup>
import { reactive } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});

const form = reactive({
  channels: null,
  email: null,
  marketing: true,
})

function submit() {
  router.post(window.route('submit'), form)
}
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative min-h-screen bg-gray-100 bg-center sm:flex sm:justify-center sm:items-center bg-dots-darker dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
    >
        <div class="w-full max-w-lg p-6 mx-auto lg:p-8">
            <!-- <h2 class="mb-10 text-2xl font-bold leading-9 tracking-tight text-center text-white">All Your YouTube's Are Belonging To Us</h2> -->

            <form @submit.prevent="submit">
                <div>
                    <label for="channel" class="block text-sm font-medium text-white leading-2">YouTube Channels</label>

                    <p class="text-sm leading-6 text-gray-400">Provide a channel per line, maximum of 100 during alpha.</p>

                    <div class="mt-2">
                        <textarea v-model="form.channels"  id="channels" placeholder="https://www.youtube.com/@youtube&#10;https://www.youtube.com/@google" rows="2" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" />
                    </div>
                </div>

                <div class="mt-5">
                    <label for="channel" class="block text-sm font-medium text-white leading-2">Email Address</label>

                    <p class="text-sm leading-6 text-gray-400">We need this so we can send you the report.</p>

                    <div class="mt-2">
                        <input v-model="form.email" id="email" type="email" autocomplete="email" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" />
                    </div>
                </div>

                <fieldset>
                    <div class="mt-6 space-y-6">
                        <div class="relative flex gap-x-3">
                            <div class="flex items-center h-6">
                                <input v-model="form.marketing" id="marketing" type="checkbox" class="w-4 h-4 text-indigo-600 rounded border-white/10 bg-white/5 focus:ring-indigo-600 focus:ring-offset-gray-900" />
                            </div>

                            <div class="text-sm leading-6">
                                <label for="marketing" class="font-medium text-white">Notifications, marketing, and such like</label>
                                <p class="text-gray-400">Get notified about features and such because why not.</p>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="flex items-center justify-end w-full mt-5 gap-x-6">
                    <button type="submit" class="w-full px-3 py-2 text-sm font-semibold text-white bg-indigo-500 rounded-md shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Submit</button>
                </div>
            </form>
        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
