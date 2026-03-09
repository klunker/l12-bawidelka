'use client';

import clsx from 'clsx';
import React from 'react';
import { Pagination } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/react';
import 'swiper/css';
import 'swiper/css/pagination';
import { OptimizedImage } from '@/components/ui/optimized-image';
import type { Reason } from '@/types/models';

interface ReasonSectionProps {
    reasons: Array<Reason>;
}

const ReasonSection: React.FC<ReasonSectionProps> = ({ reasons = [] }) => {
    const reasonCount = reasons.length;

    const renderReason = (reason: Reason) => (
        <article
            key={reason.id}
            className="group relative cursor-pointer overflow-hidden rounded-3xl bg-mint-700 shadow-lg transition-all duration-75 hover:-translate-y-1 hover:shadow-2xl"
        >
            <div className="relative h-80 md:h-96">
                <OptimizedImage
                    src={reason.image_url}
                    alt={reason.title}
                    fill
                    height={384}
                    className="object-cover transition-transform duration-700 group-hover:scale-105"
                    sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw"
                />
                <div className="absolute inset-0 bg-linear-to-t from-black/70 via-transparent to-transparent" />
                <h3 className="mb-2 text-xl font-bold text-white!">
                    {reason.title}
                </h3>
                <div className="absolute right-0 bottom-0 left-0 p-6 text-white">
                    <div
                        className="text-sm text-gray-200"
                        dangerouslySetInnerHTML={{
                            __html: reason.description,
                        }}
                    />
                </div>
            </div>
        </article>
    );

    return (
        <section className="px-4 py-16 sm:px-6 lg:px-8" id="reasons">
            <div className="mx-auto max-w-7xl">
                <div className="mb-12 text-center">
                    <h2 className="mb-4 text-3xl font-bold md:text-4xl">
                        Dlaczego warto wybrać{' '}
                        <span className="text-mint-600">Bawidełka</span>?
                    </h2>
                    {/*<p className="mx-auto max-w-2xl text-gray-600">*/}
                    {/*    Powód, dla którego warto wybrać Bawidełka. Odkryj magię*/}
                    {/*    Bawidełka &mdash; Zobacz, dlaczego warto!*/}
                    {/*</p>*/}
                </div>

                {reasonCount === 0 ? (
                    <div className="col-span-full w-full py-32 text-center text-gray-500">
                        Przepraszamy, nad tym myślimy i będzie opublikowane w
                        najbliższej wersji.
                    </div>
                ) : reasonCount > 4 ? (
                    <Swiper
                        modules={[Pagination]}
                        spaceBetween={30}
                        slidesPerView={1}
                        pagination={{ clickable: true }}
                        breakpoints={{
                            640: { slidesPerView: 2, spaceBetween: 20 },
                            768: { slidesPerView: 3, spaceBetween: 40 },
                            1024: { slidesPerView: 4, spaceBetween: 50 },
                        }}
                    >
                        {reasons.map((reason) => (
                            <SwiperSlide key={reason.id}>
                                {renderReason(reason)}
                            </SwiperSlide>
                        ))}
                    </Swiper>
                ) : (
                    <div
                        className={clsx(
                            'grid grid-cols-1 gap-8 sm:grid-cols-2',
                            {
                                'lg:grid-cols-3': reasonCount <= 3,
                                'lg:grid-cols-4': reasonCount === 4,
                            },
                        )}
                    >
                        {reasons.map(renderReason)}
                    </div>
                )}
            </div>
        </section>
    );
};

export default ReasonSection;
