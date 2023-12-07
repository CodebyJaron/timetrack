import {Company} from 'domains/companies/types';

export interface User {
    id: number;
    firstName: string;
    lastName: string;
    email: string;
    isAdmin: boolean;
    inviteToken: string;
    companies: Company[];
}
