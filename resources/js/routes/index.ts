import {authRoutes} from 'domains/auth';
import {companyRoutes} from 'domains/companies';
import {dashboardRoutes} from 'domains/dashboard';
import {hourRoutes} from 'domains/hours';
import {userRoutes} from 'domains/users';

export const routes = [...authRoutes, ...userRoutes, ...companyRoutes, ...hourRoutes, ...dashboardRoutes];
