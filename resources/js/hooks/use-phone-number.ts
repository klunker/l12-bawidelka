import { usePage } from '@inertiajs/react';
import { preparePhoneNumber } from '@/lib/utils';
import type { SharedData } from '@/types';

export function usePhoneNumber(cleared = false) {
    const props = usePage<SharedData>().props;
    const phoneNumber = props.settings.PHONE_NUMBER_FOR_CALLS || '';

    if (!phoneNumber) return '';

    if (cleared) {
        return preparePhoneNumber(phoneNumber);
    }

    return phoneNumber;
}

export default usePhoneNumber;
