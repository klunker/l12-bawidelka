'use client';

import React, { createContext, useContext, useState } from 'react';
import type { City } from '@/types/models';

interface PhoneCallContextType {
    isOpen: boolean;
    cities: Array<City> | null;
    setCities: (cities: Array<City>) => void;
    openPopup: () => void;
    closePopup: () => void;
}

const PhoneCallContext = createContext<PhoneCallContextType | undefined>(
    undefined,
);

export function PhoneCallProvider({ children }: { children: React.ReactNode }) {
    const [isOpen, setIsOpen] = useState(false);
    const [cities, setCities] = useState<Array<City> | null>(null);

    const openPopup = () => {
        if (cities && cities.length > 0) {
            setIsOpen(true);
        } else {
            // Fallback: if no cities set, make direct call
            console.warn('No cities available for phone call popup');
        }
    };

    const closePopup = () => {
        setIsOpen(false);
    };

    return (
        <PhoneCallContext.Provider
            value={{ isOpen, cities, setCities, openPopup, closePopup }}
        >
            {children}
        </PhoneCallContext.Provider>
    );
}

export function usePhoneCall() {
    const context = useContext(PhoneCallContext);
    if (context === undefined) {
        throw new Error('usePhoneCall must be used within a PhoneCallProvider');
    }
    return context;
}
