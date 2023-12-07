<template>
    <form @submit.prevent="$emit('submit', editable)">
        <h3>Gebuiker informatie:</h3>
        <FormSection>
            <FormGroup class="mb-2">
                <label for="title" class="form-label">Voornaam:</label>
                <input v-model="editable.firstName" type="text" class="form-control" />
            </FormGroup>

            <FormGroup class="mb-2">
                <label for="title" class="form-label">Achternaam:</label>
                <input v-model="editable.lastName" type="text" class="form-control" />
            </FormGroup>

            <FormGroup class="mb-2">
                <label for="title" class="form-label">Email:</label>
                <input v-model="editable.email" type="text" class="form-control" />
            </FormGroup>

            <FormGroup>
                <button type="button" class="btn btn-light text-center me-2" @click="$emit('cancel')">Annuleren</button>
                <button type="submit" class="btn btn-primary text-center">Gebruiker bewaren</button>
            </FormGroup>
        </FormSection>
    </form>
</template>

<script setup lang="ts">
import {New} from 'services/store/types';
import {User} from '../types';
import {deepCopy} from 'helpers/copy';
import {ref} from 'vue';
import FormGroup from 'components/FormGroup.vue';
import FormSection from 'components/FormSection.vue';

defineEmits<{
    (event: 'submit', data: New<User>): void;
    (event: 'cancel'): void;
}>();

const props = defineProps<{form: New<User>}>();

const editable = ref(deepCopy(props.form));
</script>
