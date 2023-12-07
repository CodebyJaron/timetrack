<template>
    <PageContainer>
        <SimpleRow>
            <div class="col-sm">
                <Card>
                    <div class="media d-flex">
                        <div class="align-self-center">
                            <!-- <FontAwesomeIcon :icon="fasMoneyCheckAlt" class="success font-lage-2 float-left" /> -->
                        </div>
                        <div class="media-body text-right">
                            <h3>{{ totalHours }}</h3>
                            <span>Totale aantal uren</span>
                        </div>
                    </div>
                </Card>
            </div>
            <div class="col-sm">
                <Card>
                    <div class="media d-flex">
                        <div class="align-self-center">
                            <!-- <FontAwesomeIcon :icon="fasMoneyCheckAlt" class="success font-lage-2 float-left" /> -->
                        </div>
                        <div class="media-body text-right">
                            <h3>{{ totalMoneyFromHoursFiltered() }}</h3>
                            <span>Totaal aantal geld</span>
                        </div>
                    </div>
                </Card>
            </div>
            <div class="col-sm">
                <Card>
                    <h1>Filter periode</h1>

                    <form @change="submit()">
                        <FormSection>
                            <FormGroup>
                                <label for="startdate">Begindatum:</label>
                                <SimpleDatePicker
                                    id="startdate"
                                    v-model="filterStartDate"
                                    @update:model-value="submit()"
                                />
                            </FormGroup>

                            <FormGroup>
                                <label for="enddate">Einddatum:</label>
                                <SimpleDatePicker id="enddate" v-model="filterEndDate" @update:model-value="submit()" />
                            </FormGroup>
                        </FormSection>
                    </form>
                </Card>
            </div>
        </SimpleRow>
    </PageContainer>
</template>

<script setup lang="ts">
import {Hour} from 'domains/hours/types';
import {companyStore} from 'domains/companies';
import {computed, ref} from 'vue';
import {hourStore} from 'domains/hours';
import {successToast} from 'services/toast';
import Card from 'components/Card.vue';
import FormGroup from 'components/FormGroup.vue';
import FormSection from 'components/FormSection.vue';
import PageContainer from 'components/PageContainer.vue';
import SimpleDatePicker from 'components/SimpleDatePicker.vue';
import SimpleRow from 'components/SimpleRow.vue';

hourStore.actions.getAll();
const hours = computed(() => hourStore.getters.all.value);

const filterStartDate = ref(new Date());
// eslint-disable-next-line no-magic-numbers
const filterEndDate = ref(new Date(Date.now() + 7 * 24 * 60 * 60 * 1000));

const filterByDateRange = (data: Array<Hour>, startDate: Date, endDate: Date) => {
    const filteredData = data.filter(item => {
        const itemDate = new Date(item.date); // Assuming each item in the data array has a "date" property
        return itemDate >= startDate && itemDate <= endDate;
    });

    return filteredData;
};

const filteredHours = computed(() => filterByDateRange(hours.value, filterStartDate.value, filterEndDate.value));

const totalHours = computed(() =>
    filteredHours.value.reduce(
        (lastReturnedValue, currentArrayItem) => lastReturnedValue + +currentArrayItem.amount,
        0,
    ),
);

companyStore.actions.getAll();

const submit = () => {
    successToast('De filter is toegepast');

    filterEndDate.value = new Date(filterEndDate.value);
    filterStartDate.value = new Date(filterStartDate.value);
};

const totalMoneyFromHoursFiltered = () => {
    const totalAmount = filteredHours.value.reduce((accumulator, {amount, companyId}) => {
        const company = companyStore.getters.byId(companyId).value;
        if (company && company.hourlyWage) return accumulator + amount * company.hourlyWage;

        return accumulator;
    }, 0);

    // eslint-disable-next-line no-magic-numbers
    return totalAmount.toFixed(2);
};
</script>
