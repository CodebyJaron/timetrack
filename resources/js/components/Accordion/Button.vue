<template>
    <h2 :id="`item${id}-heading`" class="accordion-header">
        <button
            class="accordion-button"
            :class="open ? '' : 'collapsed'"
            type="button"
            data-bs-toggle="collapse"
            :data-bs-target="`#item${id}`"
            :aria-expanded="open"
            :aria-controls="`item${id}`"
        >
            <slot />
        </button>
    </h2>
</template>

<script setup lang="ts">
defineProps({
    open: {type: Boolean, default: false},
    id: {type: Number, default: 0},
});
</script>
