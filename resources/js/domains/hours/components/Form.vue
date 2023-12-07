<template>
    <form @submit.prevent="$emit('submit', editable)">
        <h3>Uren aanpassen:</h3>
        <div class="form-row">
            <div class="col">
                <FormGroup class="mb-2">
                    <label for="title" class="form-label">Aantal uren:</label>
                    <input v-model="editable.amount" type="text" class="form-control form-input" />
                </FormGroup>
            </div>
            <div class="col">
                <FormGroup class="mb-2">
                    <label for="startdate" class="form-label mb-2">Datum:</label>
                    <SimpleDatePicker id="startdate" v-model="editable.date" :value="editable.date" />
                </FormGroup>
            </div>
            <div class="col">
                <FormGroup>
                    <label class="form-label" for="company">Bedrijf</label>
                    <select v-model="editable.companyId" class="form-select" name="company">
                        <option v-for="company in userCompanies" :key="company.id" :value="company.id">
                            {{ company.name }}
                        </option>
                    </select>
                </FormGroup>
            </div>
            <div class="col">
                <FormGroup class="mb-2">
                    <label for="title" class="form-label">Notitie:</label>
                    <textarea v-model="editable.note" type="text" class="form-control" />
                </FormGroup>
            </div>
            <div class="col-auto">
                <FormGroup>
                    <button type="button" class="btn btn-light text-center me-2" @click="$emit('cancel')">
                        Annuleren
                    </button>
                    <button type="submit" class="btn btn-primary text-center">Uren opslaan</button>
                </FormGroup>
            </div>
        </div>
    </form>
</template>

<script setup lang="ts">
import {Hour} from '../types';
import {New} from 'services/store/types';
import {companyStore} from 'domains/companies';
import {deepCopy} from 'helpers/copy';
import {getLoggedInUser} from 'domains/auth';
import {ref} from 'vue';
import FormGroup from 'components/FormGroup.vue';
import SimpleDatePicker from 'components/SimpleDatePicker.vue';

defineEmits<{
    (event: 'submit', data: New<Hour>): void;
    (event: 'cancel'): void;
}>();

const props = defineProps<{form: New<Hour>}>();

const editable = ref(deepCopy(props.form));

const userCompanies = companyStore.getters.all;

companyStore.actions.getCompaniesOfUser(getLoggedInUser.value?.id || 1);
</script>
