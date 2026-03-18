import type { InertiaLinkProps } from '@inertiajs/react';
import { clsx } from 'clsx';
import type { ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function toUrl(url: NonNullable<InertiaLinkProps['href']>): string {
    return typeof url === 'string' ? url : url.url;
}
export function callToPhone(phoneNumber: string) {
    window.location.href = `tel:${phoneNumber}`;
}

export function preparePhoneNumber(phoneNumber: string) {
    const digits = phoneNumber.replace(/\D/g, '');
    return digits.startsWith('48') ? `+${digits}` : `+48${digits}`;
}
