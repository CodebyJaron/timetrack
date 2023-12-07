<template>
    <div ref="modalTemplate" class="modal fade" tabindex="-1" aria-labelledby="label" aria-hidden="true">
        <div class="modal-dialog" :class="`modal-${modal.size}`">
            <div class="modal-content">
                <div class="modal-body">
                    <component :is="modal.component" :form="modal.form" @submit="submit" @cancel="close" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {FormModalData} from '../types';
import {Modal} from 'bootstrap';
import {createModal} from './logic';
import {onMounted, ref} from 'vue';

const props = defineProps<{modal: FormModalData}>();

const emit = defineEmits<{(event: 'hide'): void}>();

const modalTemplate = ref<HTMLDivElement>();

let bootstrapModal: Modal;

const close = () => bootstrapModal.hide();

onMounted(() => {
    if (!modalTemplate.value) return;
    bootstrapModal = createModal(modalTemplate.value, emit);
});

const submit = async (form: unknown) => {
    await props.modal.submitEvent(form);
    close();
};
</script>
