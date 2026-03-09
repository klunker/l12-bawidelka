'use client';

import AnitaAndKamila from '@images/about_as.png';
import React from 'react';

interface AboutContent {
    id: number;
    content: string;
    isActive: boolean;
}

interface AboutUsSectionProps {
    AboutContent?: AboutContent | null;
}

const AboutUsSection: React.FC<AboutUsSectionProps> = ({ AboutContent }) => {
    return (
        <section className="overflow-hidden bg-white py-24" id="about-us">
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div className="grid grid-cols-1 items-center gap-16 lg:grid-cols-2">
                    {/* Content Side */}
                    <div className="relative z-10">
                        <div className="mb-6 inline-block rounded-full bg-mint-50 px-4 py-1.5 text-sm font-bold tracking-wider text-mint-700 uppercase">
                            O nas
                        </div>

                        <h2 className="mb-8 text-4xl leading-tight font-black text-gray-900 md:text-5xl">
                            Cześć, tutaj{' '}
                            <span className="text-mint-600">Anita!</span>
                        </h2>

                        <div
                            className="space-y-6 text-lg leading-relaxed text-gray-600"
                            dangerouslySetInnerHTML={{
                                __html:
                                    AboutContent?.content ||
                                    '<p>Trwa ładowanie treści...</p>',
                            }}
                        />
                    </div>

                    {/* Image Side */}
                    <div className="relative">
                        {/* Decorative elements */}
                        <div className="animate-blob absolute -top-10 -right-10 h-64 w-64 rounded-full bg-mint-100 opacity-70 mix-blend-multiply blur-3xl filter"></div>
                        <div className="animate-blob animation-delay-2000 absolute -bottom-10 -left-10 h-64 w-64 rounded-full bg-pink-100 opacity-70 mix-blend-multiply blur-3xl filter"></div>

                        <div className="group relative overflow-hidden rounded-xl border-8 border-white shadow-2xl">
                            <img
                                src={AnitaAndKamila}
                                alt="Anita i Kamila - Założycielki Bawidełek"
                                width={800}
                                height={1000}
                                className="aspect-square h-auto w-full object-cover transition-transform duration-700 group-hover:scale-105"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
};

export default AboutUsSection;
