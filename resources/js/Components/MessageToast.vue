<script setup>
import { ref, defineProps } from 'vue';

const props = defineProps({
      message: {
        type: String
      },
      visible: {
        type: Boolean
    }
})

console.log(props.message);

</script>

<template>
    <div
      class="fixed z-10 bottom-0 left-0 mb-4 mx-5 p-4 bg-gray-800 text-white rounded shadow"
      :class="{ 'opacity-0': !props.visible, 'opacity-100': props.visible }"
      transition="opacity"
    >
      <!-- <font-awesome-icon class="text-green-500" :icon="faCircleCheck" /> -->
      <span class="px-3">
        <FontAwesomeIcon class="text-green-500 mr-2" icon="circle-check" />
        {{ props.message }}
      </span>
    </div>
  </template>


