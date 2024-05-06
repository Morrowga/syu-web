<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ActiveButton from '@/Components/ActiveButton.vue';
import InActiveButton from '@/Components/InActiveButton.vue';
import MessageToast from '@/Components/MessageToast.vue';
import { router } from '@inertiajs/core';
import { ref, defineProps, computed, onMounted } from 'vue';
import { Link,usePage } from '@inertiajs/vue3';

const props = defineProps({
    statusId :
    {
        required: true
    },
    statusUrl:
    {
        type: String,
        required: true
    },
    status:
    {
        type: Boolean,
        required: true
    },
})

console.log(props.status)

const setStatus = (status) => {
    router.post(props.statusUrl + '/' + props.statusId + '?status=' + status, {
        onSuccess: () => {
        },
    });
}
</script>
<template>
    <ActiveButton @click="setStatus(1)" v-if="!props.status">
        Set Active
    </ActiveButton>
    <InActiveButton @click="setStatus(0)" v-else>
        Set InActive
    </InActiveButton>
  </template>
