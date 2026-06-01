import { useState } from 'react';

export type UseSelectedCityReturn = {
    selectedCityId: number | null;
    setSelectedCityId: (id: number) => void;
};

export function useSelectedCityId(): UseSelectedCityReturn {
    const getCookie = (name: string) => {
        const match = document.cookie.match(
            new RegExp('(^| )' + name + '=([^;]+)'),
        );
        if (match) return match[2];
        return null;
    };

    const setCookie = (name: string, value: string) => {
        document.cookie = `${name}=${value}; path=/; max-age=${60 * 60 * 24 * 30}`;
    };

    const [selectedCityId, setSelectedCityIdState] = useState<number | null>(
        () => {
            let savedCityId = getCookie('selectedCityId');
            if (!savedCityId) {
                setCookie('selectedCityId', '1');
                savedCityId = '1';
            }
            return parseInt(savedCityId, 10);
        },
    );

    const setSelectedCityId = (id: number) => {
        setCookie('selectedCityId', id.toString());
        setSelectedCityIdState(id);
    };

    return {
        selectedCityId,
        setSelectedCityId,
    };
}
