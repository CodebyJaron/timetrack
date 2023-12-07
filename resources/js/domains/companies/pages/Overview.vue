<template>
    <PageContainer>
        <Card>
            <div class="d-flex justify-content-between">
                <h2>Werk overzicht</h2>
                <div class="d-grid gap-2 d-md-block m-1">
                    <button class="btn btn-primary" type="button" @click="createCreateModal">
                        <FontAwesomeIcon :icon="fasPlus" />
                    </button>
                </div>
            </div>
            <table class="table table-hover table-sm align-middle text-center">
                <thead>
                    <tr>
                        <th scope="col">Naam</th>
                        <th scope="col">Startdatum</th>
                        <th scope="col">Uurloon</th>
                        <th scope="col">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="work in userCompanies" :key="work.id">
                        <td>{{ work.name }}</td>
                        <td>{{ work.startDate }}</td>
                        <td>€ {{ work.hourlyWage }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" @click="createEditModal(work)">
                                <FontAwesomeIcon :icon="fasEdit" />
                            </button>
                            <button class="btn btn-primary btn-sm ms-1" @click="removeWork(work)">
                                <FontAwesomeIcon :icon="fasTrash" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </Card>
    </PageContainer>
</template>

<script setup lang="ts">
import {fasEdit, fasPlus, fasTrash} from 'constants/icons';
import {getLoggedInUser} from 'domains/auth';

import {Company} from '../types';
import {New, Updatable} from 'services/store/types';
import {companyStore} from '..';
import {computed, defineAsyncComponent, ref} from 'vue';
import {confirmModal, formModal} from 'services/modal';
import {sortBy} from 'helpers/sort';
import {successToast} from 'services/toast';
import Card from 'components/Card.vue';
import FontAwesomeIcon from 'components/FontAwesomeIcon.vue';
import PageContainer from 'components/PageContainer.vue';

companyStore.actions.getCompaniesOfUser(getLoggedInUser.value?.id || 1);

const userCompanies = computed(() => sortBy(companyStore.getters.all.value, 'startDate'));

const newWork = ref<New<Company>>({
    name: '',
    startDate: new Date(),
    userId: Number(getLoggedInUser.value?.id),
    hourlyWage: Number(0),
});

const createCreateModal = () => {
    formModal(
        newWork.value,
        defineAsyncComponent(() => import('./Form.vue')),
        async (company: New<Company>) => {
            await companyStore.actions.create(company);
            successToast('Bedrijf aangemaakt');
        },
    );
};

const createEditModal = (work: Company) => {
    formModal(
        work,
        defineAsyncComponent(() => import('./Form.vue')),
        async (editedCompany: Updatable<Company>) => {
            await companyStore.actions.update(work.id, editedCompany);
            successToast('Bedrijf aangepast');
        },
    );
};

const removeWork = async (company: Company) => {
    const confirmed = await confirmModal(`Weet je zeker dat je "${company.name}" wilt verwijderen?`, 'Verwijderen');
    if (!confirmed) return;
    companyStore.actions.delete(company.id);
    successToast('Bedrijf verwijderd');
};
</script>
