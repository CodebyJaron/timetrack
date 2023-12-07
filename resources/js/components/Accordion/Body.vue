<template>
    <div
        :id="`item${id}`"
        class="accordion-collapse collapse"
        :class="open ? 'show' : ''"
        :aria-labelledby="`item${id}-heading`"
    >
        <div class="accordion-body">
            <slot />
        </div>
    </div>
</template>

<script setup lang="ts">
defineProps({
    open: {type: Boolean, default: false},
    id: {type: Number, default: 0},
});
</script>
