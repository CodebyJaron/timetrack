import {Company} from './types';
import {createOverviewRoute} from 'services/router/factory';
import {getRequest} from 'services/http';
import {setTranslation} from 'services/translation';
import {storeModuleFactory} from 'services/store';
import OverviewPage from './pages/Overview.vue';

export const COMPANY_DOMAIN_NAME = 'companies';

setTranslation(COMPANY_DOMAIN_NAME, {
    singular: 'companie',
    plural: 'companies',
});

const baseCompanyStore = storeModuleFactory<Company>(COMPANY_DOMAIN_NAME);

export const companyStore = {
    getters: {
        ...baseCompanyStore.getters,
    },
    setters: baseCompanyStore.setters,
    actions: {
        ...baseCompanyStore.actions,
        getCompaniesOfUser: async (userId: number) => {
            const {data} = await getRequest(`${COMPANY_DOMAIN_NAME}/${userId}/get`);
            if (!data) return;
            baseCompanyStore.setters.setAll(data);
        },
    },
};
export const companyRoutes = [createOverviewRoute(COMPANY_DOMAIN_NAME, OverviewPage)];
