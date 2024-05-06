<script setup>
defineProps({
    value:
    {
        type: String,
    },
    required:
    {
        type: Boolean
    }
});
</script>

<template>
    <label class="block font-bold text-sm text-gray-700 capitalize">
        <span v-if="value">{{ value }} <span v-if="required" class="text-red-500">*</span></span>
        <span v-else><slot /></span>
    </label>
</template>
