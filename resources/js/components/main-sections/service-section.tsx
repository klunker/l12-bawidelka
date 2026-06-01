'use client';
import { Link } from '@inertiajs/react';
import { MapPin } from 'lucide-react';
import React, { useEffect, useState } from 'react';
import {
    Empty,
    EmptyDescription,
    EmptyHeader,
    EmptyTitle,
} from '@/components/ui/empty';
import { OptimizedImage } from '@/components/ui/optimized-image';
import type { City, Service } from '@/types/models';
import { useSelectedCityId } from '@/hooks/use-selected-city-id.tsx';

interface ServiceSectionContentProps {
    services: Array<Service>;
    cities: Array<City>;
}

const ServiceSectionContent: React.FC<ServiceSectionContentProps> = ({
    services,
    cities,
}) => {
    const { selectedCityId, setSelectedCityId } = useSelectedCityId();
    const [filteredServices, setFilteredServices] =
        useState<Service[]>(services);
    const handleCityChange = (cityId: number) => {
        setSelectedCityId(cityId);
    };

    useEffect(() => {
        const filteredServices = services.filter((service) => {
            if (selectedCityId === null) return true;
            return service.cities?.some(
                (city) => Number(city.id) === selectedCityId,
            );
        });
        setFilteredServices(filteredServices);
    }, [selectedCityId, services]);

    // If there are no services to display
    if (services.length === 0) {
        return (
            <Empty>
                <EmptyHeader>
                    <EmptyTitle>Brak ofert</EmptyTitle>
                    <EmptyDescription className={'text-black'}>
                        Nie utworzono jeszcze żadnych ofert.
                    </EmptyDescription>
                </EmptyHeader>
            </Empty>
        );
    }

    return (
        <div className="space-y-8">
            {/* City Switcher */}
            {cities && cities.length > 1 && (
                <div className="mb-8 flex flex-wrap justify-center gap-2">
                    {cities.map((city) => (
                        <button
                            key={city.id}
                            onClick={() => handleCityChange(city.id)}
                            className={`flex items-center gap-2 rounded-full px-6 py-2.5 text-sm font-semibold transition-all duration-300 ${
                                selectedCityId === city.id
                                    ? 'scale-105 bg-mint-600 text-white shadow-md'
                                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
                            }`}
                        >
                            <MapPin
                                className={`h-4 w-4 ${selectedCityId === city.id ? 'text-white' : 'text-mint-600'}`}
                            />
                            {city.name}
                        </button>
                    ))}
                </div>
            )}

            {filteredServices.length > 0 ? (
                <div className="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    {filteredServices.map((service) => (
                        <article key={service.id}>
                            <Link
                                href={`/oferty/${service.slug}`}
                                className="group relative block overflow-hidden rounded-3xl bg-mint-700 shadow-lg transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl"
                            >
                                <div className="relative h-80 md:h-96">
                                    <OptimizedImage
                                        src={service.image_url}
                                        alt={service.title}
                                        fill
                                        height={384}
                                        className="object-cover transition-transform duration-700 group-hover:scale-105"
                                        sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw"
                                    />
                                    <div className="absolute inset-0 bg-linear-to-t from-black/70 via-transparent to-transparent" />
                                    <div className="absolute right-0 bottom-0 left-0 p-6 text-white">
                                        <h3 className="mb-2 text-xl font-bold text-white!">
                                            {service.title}
                                        </h3>
                                        <span className="bottom-0 mt-auto mb-0 w-fit cursor-pointer text-sm font-bold text-gray-300 group-hover:text-white">
                                            Zobacz ofertę
                                        </span>
                                    </div>
                                </div>
                            </Link>
                        </article>
                    ))}
                </div>
            ) : (
                <Empty>
                    <EmptyHeader>
                        <EmptyTitle>Brak ofert</EmptyTitle>
                        <EmptyDescription className={'text-black'}>
                            Nie utworzono jeszcze żadnych ofert.
                        </EmptyDescription>
                    </EmptyHeader>
                </Empty>
            )}
        </div>
    );
};

interface ServiceSectionProps {
    services: Array<Service>;
    cities: Array<City>;
}

const ServiceSection: React.FC<ServiceSectionProps> = ({
    services,
    cities,
}) => {
    return (
        <section className="education-programs" id="services">
            <div className="programs-container">
                <div className="programs-header">
                    <p className="text-mint-800">Oferty</p>
                    <h2 className="values-title">
                        Nasze warsztaty i wydarzenia
                    </h2>
                    <p className="values-subtitle">
                        Twórz. Odkrywaj. Baw&nbsp;się.
                    </p>
                </div>
                <ServiceSectionContent services={services} cities={cities} />
            </div>
        </section>
    );
};

export default ServiceSection;
