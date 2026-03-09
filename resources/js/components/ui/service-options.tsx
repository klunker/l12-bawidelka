'use client';

import { Check } from 'lucide-react';
import React from 'react';

interface ServiceOptionsProps {
    serviceOptions?: string[];
}

const ServiceOptions: React.FC<ServiceOptionsProps> = ({ serviceOptions }) => {
    if (!serviceOptions || serviceOptions.length === 0) {
        return null;
    }

    return (
        <div className="rounded-2xl border border-gray-100 bg-gray-50 p-8">
            <h3 className="mb-6 text-xl font-semibold text-gray-900">
                Co zawiera oferta?
            </h3>
            <ul className="space-y-4">
                {serviceOptions.map((option, index) => (
                    <li
                        key={index}
                        className="flex items-start"
                    >
                        <div className="mt-1 mr-4 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-mint-100">
                            <Check className="h-4 w-4 text-mint-600" />
                        </div>
                        <span className="text-gray-700">
                            {option}
                        </span>
                    </li>
                ))}
            </ul>
        </div>
    );
};

export default ServiceOptions;
