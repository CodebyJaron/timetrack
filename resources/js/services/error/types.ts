import type {Ref} from 'vue';

export type ErrorBag = {[property: string]: string[]};
export type ErrorBagRef = Ref<ErrorBag>;
