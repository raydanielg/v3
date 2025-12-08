<script setup>
import { ref, watch } from 'vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import Toast from '@/Components/Toast.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const toastMessage = ref('');
const toastType = ref('info');
const showToast = ref(false);

const submit = () => {
    form.post(route('password.email'), {
        onFinish: () => {
            if (Object.keys(form.errors).length > 0) {
                toastMessage.value = 'Failed to send reset link. Please check your email.';
                toastType.value = 'error';
                showToast.value = true;
            }
        },
    });
};

watch(() => form.errors, (newErrors) => {
    if (Object.keys(newErrors).length > 0) {
        toastMessage.value = 'Failed to send reset link. Please check your email.';
        toastType.value = 'error';
        showToast.value = true;
    }
}, { deep: true });
</script>

<template>
    <AuthLayout>
        <Head title="Forgot Password" />

        <Toast
            v-if="showToast"
            :message="toastMessage"
            :type="toastType"
            @close="showToast = false"
        />

        <template #title>
            Forgot your password?
        </template>

        <template #subtitle>
            No problem. Enter your email and we will send you a secure link to reset it.
        </template>

        <template #header>
            <div
                v-if="status"
                class="mb-4 rounded-base border border-success-subtle bg-success-soft px-4 py-3 text-sm text-fg-success-strong"
            >
                {{ status }}
            </div>
        </template>

        <form @submit.prevent="submit" class="space-y-4">
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

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="pt-2 flex items-center justify-between gap-4">
                <Link
                    :href="route('login')"
                    class="text-xs font-medium text-emerald-600 hover:text-emerald-700 hover:underline transition-colors"
                >
                    Back to login
                </Link>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium py-2 px-4 rounded-base shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-emerald-300 transition-all disabled:opacity-60 disabled:cursor-not-allowed text-sm"
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
                    <span>{{ form.processing ? 'Sending...' : 'Send reset link' }}</span>
                </button>
            </div>
        </form>
    </AuthLayout>
</template>
