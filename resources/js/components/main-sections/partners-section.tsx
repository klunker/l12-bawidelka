'use client';

import React, { useEffect, useState } from 'react';
import { Autoplay, FreeMode } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/react';

import { OptimizedImage } from '@/components/ui/optimized-image';
import { show as partnerShow } from '@/routes/partner';
import type { Partner } from '@/types/models';
// Import Swiper React components
// Import Swiper styles
import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/autoplay';

interface PartnerSectionProps {
    partners: Array<Partner>;
}

const PartnersSection: React.FC<PartnerSectionProps> = ({ partners = [] }) => {
    const [minPartnersForScroll, setMinPartnersForScroll] = useState(5);

    useEffect(() => {
        const handleResize = () => {
            if (window.innerWidth < 768) {
                setMinPartnersForScroll(2);
            } else {
                setMinPartnersForScroll(4);
            }
        };
        handleResize();
        window.addEventListener('resize', handleResize);
        return () => window.removeEventListener('resize', handleResize);
    }, []);

    const renderPartner = (partner: Partner, index: number) => (
        <a
            key={`${partner.id}-${index}`}
            href={partnerShow.url(partner.slug)}
            target="_self"
            rel="noopener noreferrer"
            className="relative flex h-64 w-64 shrink-0 items-center justify-center transition-all duration-300 select-none hover:scale-110"
            draggable={false}
        >
            <OptimizedImage
                src={partner.logo_url}
                alt={partner.name}
                fill
                className="object-contain p-4 transition-all duration-300"
                sizes="(max-width: 768px) 160px, 200px"
            />
        </a>
    );

    return (
        <section className="bg-gray-50/50 py-20" id="partners">
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div className="mb-16 text-center">
                    <h2 className="mb-4 text-4xl font-bold tracking-tight text-gray-900">
                        Nasi Partnerzy
                    </h2>
                    <p className="text-lg text-gray-500">
                        Na szczęście, pracujemy z wieloma wspaniałymi firmami
                    </p>
                </div>

                {partners.length < minPartnersForScroll ? (
                    <div className="flex flex-wrap items-center justify-center gap-8 py-4">
                        {partners.map((partner, index) => (
                            <div
                                key={`${partner.id}-${index}`}
                                className="flex h-64 w-64 items-center justify-center"
                            >
                                {renderPartner(partner, index)}
                            </div>
                        ))}
                    </div>
                ) : (
                    <div className="mask-linear-fade relative w-full overflow-hidden">
                        <div className="pointer-events-none absolute inset-y-0 left-0 z-10 w-24 bg-gradient-to-r from-gray-50/50 to-transparent"></div>
                        <div className="pointer-events-none absolute inset-y-0 right-0 z-10 w-24 bg-gradient-to-l from-gray-50/50 to-transparent"></div>

                        <Swiper
                            modules={[Autoplay, FreeMode]}
                            loop={true}
                            freeMode={true}
                            speed={5000}
                            autoplay={{
                                delay: 0,
                                disableOnInteraction: false,
                            }}
                            slidesPerView={'auto'}
                            spaceBetween={0}
                            className="partners-swiper !ease-linear"
                            style={
                                {
                                    '--swiper-wrapper-transition-timing-function':
                                        'linear',
                                } as React.CSSProperties
                            }
                        >
                            {[...partners, ...partners].map(
                                (partner, index) => (
                                    <SwiperSlide
                                        key={`${partner.id}-${index}`}
                                        className="!h-auto !w-auto"
                                    >
                                        <div className="px-8">
                                            {renderPartner(partner, index)}
                                        </div>
                                    </SwiperSlide>
                                ),
                            )}
                        </Swiper>
                    </div>
                )}
            </div>
        </section>
    );
};

export default PartnersSection;
