'use client';

import React, { useEffect, useState } from 'react';
import type { Reason } from '@/types/models';

interface ReasonTextSectionProps {
    reasons: Array<Reason>;
}

const ReasonTextSection: React.FC<ReasonTextSectionProps> = ({
    reasons = [],
}) => {
    const [currentIndex, setCurrentIndex] = useState(0);

    useEffect(() => {
        if (reasons.length <= 1) return;

        const interval = setInterval(() => {
            setCurrentIndex((prevIndex) => (prevIndex + 1) % reasons.length);
        }, 4000); // Change every 4 seconds

        return () => clearInterval(interval);
    }, [reasons.length]);

    if (reasons.length === 0) {
        return (
            <section className="px-4 py-16 sm:px-6 lg:px-8" id="reasons">
                <div className="mx-auto max-w-4xl text-center">
                    <div className="py-32 text-center text-gray-500">
                        Przepraszamy, nad tym myślimy i będzie opublikowane w
                        najbliższej wersji.
                    </div>
                </div>
            </section>
        );
    }

    const currentReason = reasons[currentIndex];

    return (
        <section
            className="realative via-pistachio-100 bg-gradient-to-br from-mint-50 to-lavender-200 px-4 py-16 sm:px-6 lg:px-8"
            id="reasons"
        >
            <div className="mx-auto max-w-4xl py-25 text-center">
                <div className="mb-3 text-center">
                    <h2 className="mb-4 text-3xl font-bold md:text-4xl">
                        Dlaczego warto wybrać{' '}
                        <span className="text-mint-600">Bawidełka</span>?
                    </h2>
                </div>

                <div className="relative flex min-h-50 items-center justify-center">
                    <div className="absolute inset-0 flex items-center justify-center">
                        <div
                            className="transform text-center transition-all duration-1000 ease-in-out"
                            key={currentIndex}
                        >
                            <blockquote className="mb-6 text-2xl leading-relaxed font-medium text-gray-800 md:text-3xl">
                                "{currentReason.title}"
                            </blockquote>
                            <div
                                className="mx-auto max-w-2xl text-lg text-gray-600"
                                dangerouslySetInnerHTML={{
                                    __html: currentReason.description,
                                }}
                            />
                        </div>
                    </div>
                </div>

                {/* Progress indicators */}
                {reasons.length > 1 && (
                    <div className="mt-8 flex justify-center space-x-2">
                        {reasons.map((_, index) => (
                            <button
                                key={index}
                                onClick={() => setCurrentIndex(index)}
                                className={`rounded-full transition-all duration-300 ${
                                    index === currentIndex
                                        ? 'h-2 w-8 bg-mint-600'
                                        : 'h-2 w-2 bg-gray-300 hover:bg-gray-400'
                                }`}
                                aria-label={`Go to reason ${index + 1}`}
                            />
                        ))}
                    </div>
                )}
            </div>
        </section>
    );
};

export default ReasonTextSection;
