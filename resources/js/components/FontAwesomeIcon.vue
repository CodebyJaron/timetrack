<template>
    <svg
        :class="`svg-inline--fa fa-${icon.iconName}`"
        :style="size ? `font-size:${size}` : ''"
        aria-hidden="true"
        focusable="false"
        data-prefix="far"
        :data-icon="icon.iconName"
        role="img"
        xmlns="http://www.w3.org/2000/svg"
        :viewBox="`0 0 ${icon.icon[0]} ${icon.icon[1]}`"
    >
        <path fill="currentColor" :d="icon.icon[4].toString()" />
    </svg>
</template>

<script setup lang="ts">
import {IconDefinition} from './types/icon';

defineProps<{icon: IconDefinition; size?: string}>();
</script>

<style>
.svg-inline--fa {
    display: inline-block;
    height: 1em;
    overflow: visible;
    vertical-align: -0.125em;
}
</style>
