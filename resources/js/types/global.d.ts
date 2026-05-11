import type { Auth } from '@/types/auth';

declare module '@inertiajs/core' {
    export interface InertiaConfig {
        sharedPageProps: {
            name: string;
            auth: Auth;
            sidebarOpen: boolean;
            [key: string]: unknown;
        };
    }
}

declare global {
    interface Window {
        LaravelCookieConsent: {
            acceptAll(): void;
            acceptEssentials(): void;
            configure(data: unknown): void;
            reset(): void;
        };
    }
}
