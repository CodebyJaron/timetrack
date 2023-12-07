<template>
    <form @submit.prevent="$emit('submit', editable)">
        <h3>Bedrijf informatie:</h3>
        <FormSection>
            <FormGroup class="mb-2">
                <label for="title" class="form-label">Naam:</label>
                <input v-model="editable.name" type="text" class="form-control" />
            </FormGroup>

            <FormGroup class="mb-2">
                <label for="startdate" class="form-label mb-2">Startdatum:</label>
                <SimpleDatePicker id="startdate" v-model="editable.startDate" />
            </FormGroup>

            <FormGroup>
                <label for="hourly" class="form-label mb-2">Uurloon:</label>
                <input id="hourly" v-model="editable.hourlyWage" class="form-control" type="text" />
            </FormGroup>

            <FormGroup>
                <button type="button" class="btn btn-light text-center me-2" @click="$emit('cancel')">Annuleren</button>
                <button type="submit" class="btn btn-primary text-center">Bedrijf bewaren</button>
            </FormGroup>
        </FormSection>
    </form>
</template>

<script setup lang="ts">
import {Company} from '../types';
import {New} from 'services/store/types';
import {deepCopy} from 'helpers/copy';
import {ref} from 'vue';
import FormGroup from 'components/FormGroup.vue';
import FormSection from 'components/FormSection.vue';
import SimpleDatePicker from 'components/SimpleDatePicker.vue';

defineEmits<{
    (event: 'submit', data: New<Company>): void;
    (event: 'cancel'): void;
}>();

const props = defineProps<{form: New<Company>}>();

const editable = ref(deepCopy(props.form));
</script>
