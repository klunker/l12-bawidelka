'use client';
import Logotype from '@images/logo_bawidelka.png';
import React from 'react';
import FooterSectionCity from '@/components/main-sections/footer-section-city';
import { NavLinks } from '@/components/main-sections/nav-links';
import type { NavLink } from '@/types';
import type { City } from '@/types/models';

interface FooterSectionProps {
    cities: Array<City>;
}

const FooterSection: React.FC<FooterSectionProps> = ({ cities }) => {
    const links: NavLink[] = [
        { href: '/', label: 'Strona główna' },
        { href: '/#services', label: 'Oferty' },
        { href: '/#about-us', label: 'O nas' },
        { href: '/#testimonials', label: 'Opinie' },
        { href: '/#partners', label: 'Partnerzy' },
        { href: '/#contact', label: 'Kontakt' },
    ];

    const footerLinks: NavLink[] = [
        { href: '/p/privacy-policy', label: 'Polityka Prywatności' },
        {
            href: '/p/standardy-ochrony-małoletnich',
            label: 'Standardy ochrony małoletnich',
        },
        { href: '/p/regulamin', label: 'Regulamin' },
        { href: '/p/rodo', label: 'RODO' },
        { href: '/p/privacy-settings', label: 'Ustawienia prywatności' },
    ];

    return (
        <footer className="footer" id="contact">
            <div className="footer-container">
                <div className="footer-content">
                    <div className="footer-section">
                        <div className="my-16 grid grid-cols-1 gap-8 md:grid-cols-3">
                            <div className="flex flex-col items-start">
                                <img
                                    src={Logotype}
                                    alt="Bawidelka"
                                    className="mb-3 w-full max-w-2/3"
                                />
                                <p className="text-left font-medium text-black! italic">
                                    Dzielimy się dobrem, są&nbsp;miejsca
                                    w&nbsp;których jesteśmy po&nbsp;prostu.
                                </p>
                            </div>
                            {cities.map((city) => (
                                <FooterSectionCity key={city.id} city={city} />
                            ))}
                        </div>
                    </div>
                </div>
                <NavLinks links={links} className="my-8 mb-12 text-center" />
                <div className="footer-bottom mt-24">
                    <p className="text-left">
                        &copy; 2024 Bawidełka.
                        <br /> Wszystkie prawa zastrzeżone.
                    </p>
                </div>
                <NavLinks
                    className="mt-5 mb-0 flex flex-col justify-start gap-1 border-t border-t-gray-400 pt-6 text-left text-sm md:flex-row md:gap-8"
                    links={footerLinks}
                />
            </div>
        </footer>
    );
};

export default FooterSection;
