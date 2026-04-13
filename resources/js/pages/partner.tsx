'use client';

import { Link } from '@inertiajs/react';
import React from 'react';
import FooterSection from '@/components/main-sections/footer-section';
import NavigationBar from '@/components/main-sections/navigation-bar';
import SeoHead from '@/components/seo-head';
import { OptimizedImage } from '@/components/ui/optimized-image';
import type { City, Partner, SeoMeta } from '@/types/models';

interface PartnerPageProps {
    partner: Partner;
    Cities: Array<City>;
    seo?: SeoMeta | null;
}

const PartnerPage: React.FC<PartnerPageProps> = ({ partner, Cities, seo }) => {
    return (
        <>
            <SeoHead title={partner.name} seo={seo} />
            <NavigationBar />

            <main className="min-h-screen bg-gradient-to-br from-mint-50 to-white pt-20">
                <div className="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-20">
                    {/* Back button */}
                    <Link
                        href="/#partners"
                        className="group mb-12 inline-flex items-center text-gray-600 transition-all duration-200 hover:translate-x-1 hover:text-mint-600"
                    >
                        <svg
                            className="mr-2 h-5 w-5 transition-transform duration-200 group-hover:-translate-x-1"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M15 19l-7-7 7-7"
                            />
                        </svg>
                        Powrót do partnerów
                    </Link>

                    {/* Hero Section - Two Column Layout */}
                    <div className="grid gap-12 lg:grid-cols-2 lg:gap-16">
                        {/* Left Column - Content */}
                        <div className="flex flex-col justify-center space-y-8">
                            {/* Partner Badge */}
                            <div className="inline-flex">
                                <span className="rounded-full bg-mint-100 px-4 py-2 text-sm font-semibold text-mint-800">
                                    PARTNER
                                </span>
                            </div>

                            {/* Name */}
                            <div className="space-y-4">
                                <h1 className="text-4xl font-bold text-gray-900 sm:text-5xl lg:text-6xl">
                                    {partner.name}
                                </h1>
                                <div className="h-1 w-24 rounded-full bg-mint-600"></div>
                            </div>

                            {/* Description */}
                            {partner.description && (
                                <div className="prose prose-lg max-w-none text-gray-700">
                                    <div
                                        className="leading-relaxed"
                                        dangerouslySetInnerHTML={{
                                            __html: partner.description,
                                        }}
                                    />
                                </div>
                            )}

                            {/* CTA Button */}
                            {partner.url && (
                                <div className="pt-4">
                                    <a
                                        href={partner.url}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="group inline-flex items-center rounded-full bg-mint-600 px-8 py-4 text-lg font-semibold text-white shadow-lg transition-all duration-200 hover:scale-105 hover:bg-mint-700 hover:shadow-xl"
                                    >
                                        Odwiedź stronę partnera
                                        <svg
                                            className="ml-3 h-5 w-5 transition-transform duration-200 group-hover:translate-x-1"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                strokeWidth={2}
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                                            />
                                        </svg>
                                    </a>
                                </div>
                            )}
                        </div>

                        {/* Right Column - Logo/Visual */}
                        <div className="flex flex-col items-center justify-center space-y-8 lg:ml-[25%] lg:items-start lg:space-y-6">
                            {/* Logo above photo - no borders */}
                            {partner.logo_url && (
                                <div className="relative h-36 w-36 sm:h-44 sm:w-44 lg:h-52 lg:w-52">
                                    <OptimizedImage
                                        src={partner.logo_url}
                                        alt={`${partner.name} logo`}
                                        fill
                                        className="object-contain"
                                        sizes="(max-width: 640px) 160px, (max-width: 1024px) 192px, 224px"
                                    />
                                </div>
                            )}

                            {/* Partner Photo */}
                            {partner.photo_url ? (
                                <div className="relative">
                                    <div className="absolute inset-0 rounded-3xl bg-gradient-to-br from-mint-200 to-mint-400 opacity-20 blur-3xl"></div>
                                    <div className="relative overflow-hidden rounded-3xl shadow-2xl">
                                        <div className="relative h-64 w-64 sm:h-80 sm:w-80 lg:h-96 lg:w-96">
                                            <OptimizedImage
                                                src={partner.photo_url}
                                                alt={`${partner.name} photo`}
                                                fill
                                                className="object-cover"
                                                sizes="(max-width: 640px) 256px, (max-width: 1024px) 320px, 384px"
                                            />
                                        </div>
                                    </div>
                                </div>
                            ) : (
                                <div className="relative">
                                    <div className="absolute inset-0 rounded-3xl bg-gradient-to-br from-mint-200 to-mint-400 opacity-20 blur-3xl"></div>
                                    <div className="relative flex h-80 w-80 items-center justify-center rounded-3xl bg-white shadow-2xl">
                                        <div className="text-center">
                                            <div className="mx-auto mb-4 flex h-24 w-24 items-center justify-center rounded-full bg-mint-100">
                                                <span className="text-4xl font-bold text-mint-600">
                                                    {partner.name.charAt(0)}
                                                </span>
                                            </div>
                                            <p className="text-gray-500">
                                                No photo available
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </main>

            <FooterSection cities={Cities} />
        </>
    );
};

export default PartnerPage;
