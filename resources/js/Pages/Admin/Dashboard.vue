<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    admin:Object
})
</script>

<template>
    <h1>Dashboard</h1>
    <Link
        :href="route('admin.logout')"
    >
        Logout
    </Link>
    {{ admin }}
</template>
