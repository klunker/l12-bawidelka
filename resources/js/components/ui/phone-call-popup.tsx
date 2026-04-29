'use client';

import { X } from 'lucide-react';
import { useEffect } from 'react';
import { usePhoneCall } from '@/contexts/phone-call-context';
import { directCallToPhone, preparePhoneNumber } from '@/lib/utils';

export function PhoneCallPopup() {
    const { isOpen, cities, closePopup, openPopup } = usePhoneCall();

    useEffect(() => {
        const handlePhoneCallRequest = () => {
            openPopup();
        };

        window.addEventListener(
            'phoneCallRequested',
            handlePhoneCallRequest as EventListener,
        );

        return () => {
            window.removeEventListener(
                'phoneCallRequested',
                handlePhoneCallRequest as EventListener,
            );
        };
    }, [openPopup]);

    if (!isOpen || !cities) return null;

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div className="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
                <div className="mb-4 flex items-center justify-between">
                    <h2 className="text-xl font-bold text-gray-800">
                        Wybierz miasto do połączenia
                    </h2>
                    <button
                        onClick={closePopup}
                        className="rounded-full p-2 text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-700"
                        aria-label="Zamknij"
                    >
                        <X className="h-5 w-5" />
                    </button>
                </div>

                <div className="space-y-3">
                    {cities.map((city) => (
                        <button
                            key={city.id}
                            onClick={() => {
                                directCallToPhone(preparePhoneNumber(city.phone));
                                closePopup();
                            }}
                            className="w-full rounded-xl border-2 border-brand-color-mint bg-brand-bgColor-mint p-4 text-left transition-all hover:border-brand-color-mint hover:shadow-md"
                        >
                            <div className="mb-1 text-sm font-semibold text-gray-700">
                                {city.title || city.name}
                            </div>
                            <div className="text-lg font-bold text-gray-900">
                                {city.phone}
                            </div>
                        </button>
                    ))}
                </div>
            </div>
        </div>
    );
}
