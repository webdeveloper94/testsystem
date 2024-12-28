<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Kirish" />

        <!-- Status Message -->
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600 transition-all duration-500 ease-in-out">
            {{ status }}
        </div>

        <!-- Login Form -->
        <form @submit.prevent="submit" class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-lg shadow-blue-500/30 mt-8 transition-all duration-500 ease-in-out transform hover:scale-105">
            <div class="space-y-4">
                <!-- Email Input -->
                <div>
                    <InputLabel for="email" value="Elektron pochta" />
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <!-- Password Input -->
                <div>
                    <InputLabel for="password" value="Parol" />
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center space-x-2">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="text-sm text-gray-600">Meni eslab qol</span>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex justify-between items-center">
                    <!-- Forgot Password Link -->
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-sm text-indigo-600 hover:text-indigo-900 transition duration-300 ease-in-out"
                    >
                        Parolni unutdingizmi?
                    </Link>

                    <!-- Login Button -->
                    <PrimaryButton
                        class="bg-indigo-600 hover:bg-indigo-700 text-white w-full py-2 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out"
                        :class="{ 'opacity-50': form.processing }"
                        :disabled="form.processing"
                    >
                        Kirish
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>

