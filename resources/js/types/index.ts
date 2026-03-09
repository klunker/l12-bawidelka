export type * from './auth';
export type * from './navigation';
export type * from './ui';

import type { Auth } from './auth';

export type SharedData = {
    name: string;
    auth: Auth;
    sidebarOpen: boolean;
    settings: SettingsVariables;
    [key: string]: unknown;
};

export type SettingsVariables = {
    PHONE_NUMBER_FOR_CALLS: string;
    [key: string]: string;
};
