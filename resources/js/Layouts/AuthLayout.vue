<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-neutral-primary flex items-stretch">
        <!-- Left: form area -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-4 py-8 sm:px-8 lg:px-16">
            <div class="w-full max-w-md bg-neutral-primary-soft border border-default rounded-2xl shadow-md px-6 sm:px-8 py-8 sm:py-10">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-heading">
                            <slot name="title">Welcome back</slot>
                        </h1>
                        <p class="mt-1 text-sm text-body">
                            <slot name="subtitle">Sign in to continue to your account.</slot>
                        </p>
                    </div>
                    <Link href="/" class="hidden sm:inline-flex items-center justify-center">
                        <img
                            src="/letter-m_9326491.png"
                            alt="Emas logo"
                            class="h-10 w-10 rounded-lg object-cover"
                        />
                    </Link>
                </div>

                <!-- Optional top content (e.g. status, alerts) -->
                <slot name="header" />

                <!-- Main form content from page -->
                <slot />

                <!-- Optional footer (e.g. links under form) -->
                <slot name="footer" />
            </div>
        </div>

        <!-- Right: marketing / hero panel (green/yellow NECTA-inspired) -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-emerald-700 via-emerald-800 to-lime-500 text-white items-center justify-center px-10">
            <div class="max-w-md">
                <div class="flex items-center gap-2 mb-6">
                    <img
                        src="/letter-m_9326491.png"
                        alt="Emas logo"
                        class="h-9 w-9 rounded-lg object-cover bg-white/10 p-1"
                    />
                    <div class="text-lg font-semibold">Emas</div>
                </div>
                <h2 class="text-3xl font-bold leading-tight mb-3">
                    Explore powerful electronic marking &amp; results management.
                </h2>
                <p class="text-sm text-white/90 mb-6">
                    Centralize exam marking, approvals, and publishing in one modern
                    platform. Designed for institutions that care about accuracy,
                    speed, and a great experience for students.
                </p>
                <div class="flex items-center gap-4">
                    <div class="flex -space-x-2">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-xs font-medium">EM</span>
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/20 text-xs font-medium">AC</span>
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/30 text-xs font-medium">TZ</span>
                    </div>
                    <div class="text-xs leading-tight">
                        <div class="font-semibold">Trusted by institutions</div>
                        <div class="text-white/80">Secure, audited, and optimized for results.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
