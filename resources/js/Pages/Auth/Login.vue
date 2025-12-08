<script setup>
import { ref, watch } from 'vue';
import Checkbox from '@/Components/Checkbox.vue';
import Toast from '@/Components/Toast.vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';
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

const toastMessage = ref('');
const toastType = ref('info');
const showToast = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
            if (Object.keys(form.errors).length > 0) {
                toastMessage.value = 'Failed to login. Please check your credentials.';
                toastType.value = 'error';
                showToast.value = true;
            }
        },
    });
};

watch(() => form.errors, (newErrors) => {
    if (Object.keys(newErrors).length > 0) {
        toastMessage.value = 'Failed to login. Please check your credentials.';
        toastType.value = 'error';
        showToast.value = true;
    }
}, { deep: true });
</script>

<template>
    <AuthLayout>
        <Head title="Log in" />

        <Toast
            v-if="showToast"
            :message="toastMessage"
            :type="toastType"
            @close="showToast = false"
        />

        <template #title>
            Welcome back
        </template>

        <template #subtitle>
            Sign in to continue to Emas | Electronic marking system.
        </template>

        <template #header>
            <div v-if="status" class="mb-4 rounded-base border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
                {{ status }}
            </div>

            <!-- Demo Credentials Info -->
            <div class="mb-6 p-4 rounded-lg bg-blue-50 border border-blue-200">
                <p class="text-xs font-semibold text-blue-900 mb-2 flex items-center gap-2">
                    <span class="material-icons text-sm">info</span>
                    Demo Credentials
                </p>
                <div class="space-y-1 text-xs text-blue-800">
                    <p><strong>Admin:</strong> airezra2@gmail.com / 12345678</p>
                    <p><strong>Teacher:</strong> john@example.com / password123</p>
                    <p><strong>Student:</strong> jane@example.com / password123</p>
                </div>
            </div>

            <!-- Social auth placeholders -->
            <div class="mb-6 grid grid-cols-1 gap-3 sm:grid-cols-2">
                <button
                    type="button"
                    class="inline-flex items-center justify-center gap-2 rounded-base border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-medium text-emerald-900 hover:bg-emerald-100 focus:outline-none focus:ring-4 focus:ring-emerald-300 transition-colors"
                >
                    <img
                        src="https://www.svgrepo.com/show/475656/google-color.svg"
                        alt="Google"
                        class="h-4 w-4"
                    />
                    <span>Google</span>
                </button>

                <button
                    type="button"
                    class="inline-flex items-center justify-center gap-2 rounded-base border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-medium text-emerald-900 hover:bg-emerald-100 focus:outline-none focus:ring-4 focus:ring-emerald-300 transition-colors"
                >
                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true"
                    >
                        <path
                            fill="currentColor"
                            d="M16.365 1.43c-1.232.085-2.707.86-3.566 1.87-.78.91-1.435 2.38-1.26 3.77h.06c1.37 0 2.774-.8 3.6-1.82.78-.97 1.37-2.45 1.166-3.82Zm3.943 11.245c-.06-3.23 2.646-4.79 2.767-4.87-1.51-2.2-3.857-2.5-4.676-2.53-1.986-.2-3.877 1.16-4.878 1.16-1.02 0-2.575-1.13-4.25-1.1-2.17.03-4.18 1.26-5.29 3.2-2.27 3.94-.58 9.76 1.6 12.94 1.06 1.53 2.31 3.25 3.95 3.2 1.6-.07 2.2-1.03 4.14-1.03 1.93 0 2.47 1.03 4.19.99 1.73-.03 2.82-1.56 3.87-3.1 1.25-1.81 1.76-3.57 1.79-3.66-.04-.02-3.42-1.31-3.47-5.11Z"
                        />
                    </svg>
                    <span>Apple</span>
                </button>
            </div>

            <div class="mb-6 flex items-center gap-3 text-xs text-body">
                <div class="h-px flex-1 bg-emerald-200"></div>
                <span>or</span>
                <div class="h-px flex-1 bg-emerald-200"></div>
            </div>
        </template>

        <form @submit.prevent="submit" class="space-y-4" novalidate>
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError v-if="form.errors.email" class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError v-if="form.errors.password" class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="text-sm text-body">Remember me</span>
                </label>

                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm font-medium text-emerald-600 hover:text-emerald-700 hover:underline transition-colors"
                >
                    Forgot password?
                </Link>
            </div>

            <div class="pt-2">
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
                    <span>{{ form.processing ? 'Signing in...' : 'Sign in to your account' }}</span>
                </button>
            </div>
        </form>

        <template #footer>
            <p class="mt-6 text-center text-xs text-body">
                Don't have an account?
                <Link :href="route('register')" class="font-semibold text-emerald-600 hover:text-emerald-700 hover:underline transition-colors">
                    Sign up
                </Link>
            </p>
        </template>
    </AuthLayout>
</template>
