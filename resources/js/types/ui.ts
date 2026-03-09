import type { ReactNode } from 'react';
import type { BreadcrumbItem } from './navigation';

export type AppLayoutProps = {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
};

export type AuthLayoutProps = {
    children?: ReactNode;
    name?: string;
    title?: string;
    description?: string;
};

declare module '@radix-ui/themes' {
    interface ThemeProps {
        accentColor?:
            | 'accent'
            | 'ruby'
            | 'gray'
            | 'gold'
            | 'bronze'
            | 'brown'
            | 'yellow'
            | 'amber'
            | 'orange'
            | 'tomato'
            | 'red'
            | 'crimson'
            | 'pink'
            | 'plum'
            | 'purple'
            | 'violet'
            | 'iris'
            | 'indigo'
            | 'blue'
            | 'cyan'
            | 'teal'
            | 'jade'
            | 'green'
            | 'grass'
            | 'lime'
            | 'sky'
            | 'mint';
    }
}
