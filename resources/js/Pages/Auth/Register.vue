<script setup>
import { ref, watch } from 'vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import Toast from '@/Components/Toast.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'admin',
});

const toastMessage = ref('');
const toastType = ref('info');
const showToast = ref(false);

const submit = () => {
    form.post(route('register'), {
        onFinish: () => {
            if (Object.keys(form.errors).length > 0) {
                toastMessage.value = 'Failed to create account. Please check your information.';
                toastType.value = 'error';
                showToast.value = true;
            } else {
                form.reset('password', 'password_confirmation');
            }
        },
    });
};

watch(() => form.errors, (newErrors) => {
    if (Object.keys(newErrors).length > 0) {
        toastMessage.value = 'Failed to create account. Please check your information.';
        toastType.value = 'error';
        showToast.value = true;
    }
}, { deep: true });
</script>

<template>
    <AuthLayout>
        <Head title="Register" />

        <Toast
            v-if="showToast"
            :message="toastMessage"
            :type="toastType"
            @close="showToast = false"
        />

        <template #title>
            Create your account
        </template>

        <template #subtitle>
            Join Emas | Electronic marking system and get started in a few steps.
        </template>

        <form @submit.prevent="submit" class="space-y-4">
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <InputLabel for="name" value="Full name" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="sm:col-span-2">
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div>
                    <InputLabel for="password" value="Password" />

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div>
                    <InputLabel
                        for="password_confirmation"
                        value="Confirm password"
                    />

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />

                    <InputError v-if="form.errors.password_confirmation" class="mt-2" :message="form.errors.password_confirmation" />
                </div>
            </div>

            <!-- Role Selection -->
            <div>
                <InputLabel for="role" value="Role" />
                <select
                    id="role"
                    v-model="form.role"
                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
                >
                    <option value="admin">Admin</option>
                    <option value="teacher">Mwalimu (Teacher)</option>
                    <option value="school_manager">Mkuu wa Shule (School Manager)</option>
                    <option value="district_manager">Msimamizi wa Kiti (District Manager)</option>
                    <option value="student">Mwanafunzi (Student)</option>
                </select>
                <InputError v-if="form.errors.role" class="mt-2" :message="form.errors.role" />
            </div>

            <div class="pt-2 space-y-4">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium py-2.5 px-4 rounded-base shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-emerald-300 transition-all disabled:opacity-60 disabled:cursor-not-allowed"
                >
                    <svg
                        v-if="form.processing"
                        class="w-4 h-4 animate-spin"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>{{ form.processing ? 'Creating account...' : 'Create account' }}</span>
                </button>

                <p class="text-center text-xs text-body">
                    Already registered?
                    <Link
                        :href="route('login')"
                        class="font-semibold text-emerald-600 hover:text-emerald-700 hover:underline transition-colors"
                    >
                        Sign in
                    </Link>
                </p>
            </div>
        </form>
    </AuthLayout>
</template>
