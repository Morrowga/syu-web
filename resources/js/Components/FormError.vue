<script setup>
import { defineProps } from "vue";

defineProps({
    message: {
        type: String,
    },
});

</script>

<template>
    <div class="font-medium text-sm text-red-500 my-3" v-if="message != null">
        <span>{{ message }}</span>
    </div>
</template>
