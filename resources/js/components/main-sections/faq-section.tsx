'use client';

import { ChevronDown } from 'lucide-react';
import { useState } from 'react';
import type { FAQItem } from '@/types/models';

interface FaqSectionProps {
    faqs: Array<FAQItem>;
}

const FAQ: React.FC<FaqSectionProps> = ({ faqs }) => {
    const [openIds, setOpenIds] = useState<string[]>([]);

    const toggleFAQ = (id: string) => {
        setOpenIds((prev) =>
            prev.includes(id)
                ? prev.filter((item) => item !== id)
                : [...prev, id],
        );
    };

    const renderFaq = (item: FAQItem, isOpen: boolean) => (
        <div key={item.id} className="border-b border-gray-200">
            <button
                className="group flex w-full items-center justify-between py-6 text-left hover:cursor-pointer focus:outline-none"
                onClick={() => toggleFAQ(item.id)}
                aria-expanded={isOpen}
            >
                <span
                    className={`text-lg font-medium transition-colors duration-200 ${isOpen ? 'text-brown-600' : 'text-gray-900 group-hover:text-brown-600'}`}
                >
                    {item.question}
                </span>
                <span
                    className={`ml-6 flex-shrink-0 transition-transform duration-300 ${isOpen ? 'rotate-180 transform text-brown-600' : 'text-gray-400 group-hover:text-brown-600'}`}
                >
                    <ChevronDown className="h-6 w-6" />
                </span>
            </button>

            <div
                className={`overflow-hidden transition-all duration-300 ease-in-out ${
                    isOpen ? 'max-h-96 pb-6 opacity-100' : 'max-h-0 opacity-0'
                }`}
            >
                <div
                    className="pr-12 leading-relaxed text-gray-600"
                    dangerouslySetInnerHTML={{
                        __html: item.answer,
                    }}
                />
            </div>
        </div>
    );

    return (
        <section className="bg-white py-24" id="faq">
            <div className="mx-auto max-w-7xl px-6">
                <div className="mb-16 text-center">
                    <h2 className="mb-4 text-4xl font-bold tracking-tight text-gray-900">
                        Najczęściej zadawane pytania
                    </h2>
                    {/*<p className="text-lg text-gray-500">*/}
                    {/*    Wszystko co musisz wiedzieć o naszej bawialni.*/}
                    {/*</p>*/}
                </div>
                {faqs && faqs.length > 0 ? (
                    faqs.map((item: FAQItem) => {
                        const isOpen = openIds.includes(item.id);
                        return renderFaq(item, isOpen);
                    })
                ) : (
                    <div className="col-span-full w-full py-32 text-center text-gray-500">
                        Przepraszamy, nad tym myślimy i będzie opublikowane w
                        najbliższej wersji.
                    </div>
                )}

                <div className="border-t border-gray-200"></div>
            </div>
        </section>
    );
};

export default FAQ;
