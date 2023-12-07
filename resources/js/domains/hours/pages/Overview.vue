<template>
    <PageContainer>
        <!-- <form @submit.prevent="submit()">
            <Card>
                <h1>Uren opschrijven</h1>

                <div class="text-center">
                    <FormGroup>
                        <label for="amount">Gewerkte uren?</label>
                        <input id="amount" v-model="newHour.amount" type="text" required />
                    </FormGroup>

                    <FormGroup>
                        <label for="startdate">Startdatum:</label>
                        <SimpleDatePicker id="startdate" v-model="newHour.date" />
                    </FormGroup>

                    <FormGroup>
                        <label for="company">Bedrijf</label>
                        <select v-model="newHour.companyId" name="company">
                            <option v-for="company in userCompanies" :key="company.id" :value="company.id">
                                {{ company.name }}
                            </option>
                        </select>
                    </FormGroup>

                    <FormGroup class="mb-2">
                        <label for="title" class="form-label">Notitie:</label>
                        <textarea v-model="newHour.note" type="text" class="form-control" />
                    </FormGroup>
                </div>

                <button class="" type="submit">Submit</button>
            </Card>
        </form> -->

        <form @submit.prevent="submit()">
            <Card>
                <h1>Uren opschrijven</h1>
                <!-- Gutter g-1 -->
                <div class="row p-2">
                    <div class="col">
                        <!-- Name input -->
                        <div class="form-outline">
                            <label for="amount" class="form-label">Gewerkte uren?</label>
                            <input id="amount" v-model="newHour.amount" type="text" class="form-control" required />
                        </div>
                    </div>
                    <div class="col">
                        <!-- Email input -->
                        <label for="company" class="form-label">Bedrijf</label>
                        <select v-model="newHour.companyId" class="form-control" name="company">
                            <option v-for="company in userCompanies" :key="company.id" :value="company.id">
                                {{ company.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <hr />

                <div class="row p-2">
                    <div class="col">
                        <div class="form-outline">
                            <label class="form-label" for="startdate">Datum:</label>
                            <SimpleDatePicker id="startdate" v-model="newHour.date" />
                            <!-- Zelf invoeren: string 05-04-2023 -->
                            <!-- 2023-06-13T12:22:43.669Z -->
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline">
                            <label for="title" class="form-label">Notitie:</label>
                            <textarea v-model="newHour.note" type="text" class="form-control" />
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Submit</button>
            </Card>
        </form>

        <Card v-if="hours && userCompanies">
            <div class="d-flex justify-content-between">
                <h2>Uren overzicht</h2>
            </div>
            <table class="table table-hover table-striped table-sm align-middle text-center">
                <thead>
                    <tr>
                        <th scope="col">Datum</th>
                        <th scope="col">Aantal uur</th>
                        <th scope="col">Bedrijf</th>
                        <th scope="col">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="hour in hoursToDisplay" :key="hour.id">
                        <td>{{ beautifyDate(hour.date) }}</td>
                        <td>{{ hour.amount }}</td>
                        <td>{{ getCompanyById(hour.companyId) }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" @click="createEditModal(hour)">
                                <FontAwesomeIcon :icon="fasEdit" />
                            </button>
                            <button class="btn btn-primary btn-sm ms-1" @click="removeHour(hour)">
                                <FontAwesomeIcon :icon="fasTrash" />
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tfoot v-if="hoursToDisplay.length >= 1" class="d-flex">
                    <nav aria-label="Paginator" class="text-center">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" @click="previousPage()">Previous</a></li>
                            <li class="page-item">
                                <a v-if="currentPage > 1" class="page-link" @click="goToPage(currentPage - 1)">
                                    {{ currentPage - 1 }}
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link disabled hover-default">{{ currentPage }}</a>
                            </li>
                            <li class="page-item">
                                <a v-if="totalPages > currentPage" class="page-link" @click="goToPage(currentPage + 1)">
                                    {{ currentPage + 1 }}
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link" @click="nextPage()">Next</a></li>
                        </ul>
                    </nav>
                </tfoot>
            </table>
        </Card>
    </PageContainer>
</template>

<script setup lang="ts">
import {fasEdit, fasTrash} from 'constants/icons';

import {Hour} from '../types';
import {New, Updatable} from 'services/store/types';
import {beautifyDate} from 'helpers/date';
import {companyStore} from 'domains/companies';
import {computed, defineAsyncComponent, ref} from 'vue';
import {confirmModal, formModal} from 'services/modal';
import {hourStore} from '..';
import {sortBy} from 'helpers/sort';
import {successToast} from 'services/toast';
import Card from 'components/Card.vue';
import FontAwesomeIcon from 'components/FontAwesomeIcon.vue';
import PageContainer from 'components/PageContainer.vue';
import SimpleDatePicker from 'components/SimpleDatePicker.vue';

hourStore.actions.getAll();

const hours = computed(() => sortBy(hourStore.getters.all.value, 'date').reverse());

const createDateString = `${new Date().getFullYear()}-${new Date().getMonth() + 1}-${new Date().getDate()}`;

const newHour = ref<New<Hour>>({
    amount: 0,
    date: createDateString,
    companyId: NaN,
    note: '',
});

const submit = () => {
    hourStore.actions.create(newHour.value);
    successToast('Je uren zijn opgeschreven');
};

companyStore.actions.getAll();

const getCompanyById = (companyId: number) => {
    const company = companyStore.getters.byId(companyId);
    if (!company.value) return;
    return company.value.name;
};

const userCompanies = computed(() => companyStore.getters.all).value;

const createEditModal = (hour: Hour) => {
    formModal(
        hour,
        defineAsyncComponent(() => import('../components/Form.vue')),
        async (editedHour: Updatable<Hour>) => {
            await hourStore.actions.update(hour.id, editedHour);
            successToast('Uren aangepast');
        },
    );
};

const removeHour = async (hour: Hour) => {
    const confirmed = await confirmModal('Weet je zeker dat je deze uren wilt verwijderen?', 'Verwijderen');
    if (!confirmed) return;
    hourStore.actions.delete(hour.id);
    successToast('Uren verwijderd');
};

const itemsPerPage = 10;
const currentPage = ref(1);

const totalPages = computed(() => Math.ceil(hours.value.length / itemsPerPage));

const hoursToDisplay = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    return hours.value.slice(startIndex, endIndex);
});

const nextPage = () => {
    if (currentPage.value < getTotalPages()) currentPage.value++;
};

// Function to navigate to the previous page
const previousPage = () => {
    if (currentPage.value > 1) currentPage.value--;
};

// Function to navigate to a specific page
const goToPage = (page: number) => {
    if (page >= 1 && page <= getTotalPages()) currentPage.value = page;
};

// Function to calculate the total number of pages
const getTotalPages = () => Math.ceil(hours.value.length / itemsPerPage);
</script>
