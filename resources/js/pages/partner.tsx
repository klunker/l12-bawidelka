'use client';

import { Link } from '@inertiajs/react';
import React from 'react';
import FooterSection from '@/components/main-sections/footer-section';
import NavigationBar from '@/components/main-sections/navigation-bar';
import SeoHead from '@/components/seo-head';
import { OptimizedImage } from '@/components/ui/optimized-image';
import type { City, Partner } from '@/types/models';

interface PartnerPageProps {
    partner: Partner;
    Cities: Array<City>;
    seo?: {
        title?: string | null;
        description?: string | null;
        keywords?: string | null;
    } | null;
}

const PartnerPage: React.FC<PartnerPageProps> = ({ partner, Cities, seo }) => {
    return (
        <>
            <SeoHead title={partner.name} seo={seo} />
            <NavigationBar />

            <main className="min-h-screen bg-gray-50 pt-20">
                <div className="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8">
                    {/* Back button */}
                    <Link
                        href="/#partners"
                        className="mb-8 inline-flex items-center text-gray-600 transition-colors hover:text-gray-900"
                    >
                        <svg
                            className="mr-2 h-5 w-5"
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

                    {/* Partner info */}
                    <div className="overflow-hidden rounded-lg bg-white shadow-lg">
                        <div className="p-8">
                            {/* Logo */}
                            {partner.logo_url && (
                                <div className="mb-8 flex justify-center">
                                    <div className="relative h-48 w-48">
                                        <OptimizedImage
                                            src={partner.logo_url}
                                            alt={partner.name}
                                            fill
                                            className="object-contain"
                                            sizes="(max-width: 768px) 192px, 192px"
                                        />
                                    </div>
                                </div>
                            )}

                            {/* Name */}
                            <h1 className="mb-6 text-center text-3xl font-bold text-gray-900">
                                {partner.name}
                            </h1>

                            {/* Description */}
                            {partner.description && (
                                <div className="prose prose-lg mb-8 max-w-none">
                                    <div
                                        className="leading-relaxed text-gray-700"
                                        dangerouslySetInnerHTML={{
                                            __html: partner.description,
                                        }}
                                    />
                                </div>
                            )}

                            {/* External link */}
                            {partner.url && (
                                <div className="text-center">
                                    <a
                                        href={partner.url}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-6 py-3 text-base font-medium text-white transition-colors hover:bg-blue-700"
                                    >
                                        Odwiedź stronę partnera
                                        <svg
                                            className="ml-2 h-5 w-5"
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
                    </div>
                </div>
            </main>

            <FooterSection cities={Cities} />
        </>
    );
};

export default PartnerPage;
