<template>
    <div ref="modalTemplate" class="modal fade" tabindex="-1" aria-labelledby="label" aria-hidden="true">
        <div class="modal-dialog modal-xl" :class="`modal-${modal.size}`">
            <div class="modal-content">
                <div ref="modalBody" class="modal-body">
                    <component :is="modal.component" v-bind="modal.props" @hide="close" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {Modal} from 'bootstrap';
import {ShowModalData} from '../types';
import {createModal} from './logic';
import {onMounted, ref} from 'vue';

defineProps<{modal: ShowModalData}>();

const emit = defineEmits<{(event: 'hide'): void}>();

const modalTemplate = ref<HTMLDivElement>();
const modalBody = ref<HTMLDivElement>();

let bootstrapModal: Modal;

const close = () => bootstrapModal.hide();

onMounted(() => {
    if (!modalTemplate.value) return;
    bootstrapModal = createModal(modalTemplate.value, emit, true, true);

    if (modalTemplate.value?.children[0].classList.contains('modal-fullscreen') && modalBody.value)
        modalBody.value.style.padding = '0';
});
</script>
