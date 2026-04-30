'use client';

import { X, Phone, MapPin } from 'lucide-react';
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
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 animate-in fade-in duration-200">
            <div className="w-full max-w-md overflow-hidden rounded-3xl bg-white shadow-2xl animate-in slide-in-from-bottom-4 duration-300">
                {/* Header with gradient */}
                <div className="bg-linear-to-r from-brand-color-mint to-brand-color-pistachio pt-6">
                    <div className="flex items-center justify-between">
                        <div className="flex items-center gap-1">
                            <div className="flex h-12 w-12 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm">
                                <Phone className="h-6 w-6 text-white" />
                            </div>
                            <div>
                                <h2 className="text-xl font-bold text-gray-900 mb-0!">
                                    Wybierz miasto
                                </h2>
                                <p className="text-sm text-gray-700">
                                    Zadzwoń do nas
                                </p>
                            </div>
                        </div>
                        <button
                            onClick={closePopup}
                            className="flex h-10 w-10 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm text-gray-700 transition-all hover:bg-white/40 hover:scale-110"
                            aria-label="Zamknij"
                        >
                            <X className="h-5 w-5" />
                        </button>
                    </div>
                </div>

                {/* City list */}
                <div className="p-6 space-y-2">
                    {cities.map((city, index) => (
                        <button
                            key={city.id}
                            onClick={() => {
                                directCallToPhone(preparePhoneNumber(city.phone));
                                closePopup();
                            }}
                            className="group relative w-full overflow-hidden rounded-md border-2 border-gray-100 bg-white p-4 text-left transition-all duration-300 hover:border-brand-color-mint hover:shadow-lg hover:shadow-brand-color-mint/20 hover:-translate-y-1"
                            style={{
                                animationDelay: `${index * 50}ms`,
                            }}
                        >
                            <div className="absolute inset-0 bg-linear-to-r from-brand-color-mint/0 via-brand-color-mint/5 to-brand-color-mint/0 opacity-0 transition-opacity duration-300 group-hover:opacity-100" />

                            <div className="relative flex items-center gap-4">
                                <div className="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-bgColor-mint text-brand-color-mint transition-all duration-300 group-hover:scale-110 group-hover:bg-brand-color-mint">
                                    <MapPin className="h-5 w-5" />
                                </div>

                                <div className="flex-1 min-w-0">
                                    <div className="mb-1 text-sm font-semibold text-gray-700 truncate">
                                        {city.title || city.name}
                                    </div>
                                    <div className="flex items-center gap-2">
                                        <div className="text-lg font-bold text-gray-900">
                                            {city.phone}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </button>
                    ))}
                </div>

                {/* Footer */}
                <div className="border-t border-gray-100 bg-gray-50 px-6 py-4">
                    <p className="text-center text-xs text-gray-500">
                        Kliknij na miasto, aby zadzwonić
                    </p>
                </div>
            </div>
        </div>
    );
}
