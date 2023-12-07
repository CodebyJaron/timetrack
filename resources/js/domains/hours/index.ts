import {Hour} from './types';
import {createOverviewRoute} from 'services/router/factory';
import {setTranslation} from 'services/translation';
import {storeModuleFactory} from 'services/store';
import OverviewPage from './pages/Overview.vue';

export const HOUR_DOMAIN_NAME = 'hours';

setTranslation(HOUR_DOMAIN_NAME, {
    singular: 'hours',
    plural: 'hours',
});

export const hourStore = storeModuleFactory<Hour>(HOUR_DOMAIN_NAME);

export const hourRoutes = [createOverviewRoute(HOUR_DOMAIN_NAME, OverviewPage)];
