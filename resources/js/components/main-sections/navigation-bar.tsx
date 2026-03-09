'use client';

import bawidelkaLogo from '@images/bawidelka.svg';
import { Link } from '@inertiajs/react';
import { Button } from '@radix-ui/themes';
import { Menu, Phone, X } from 'lucide-react';
import { useEffect, useState } from 'react';
import { NavLinks } from '@/components/main-sections/nav-links';
import usePhoneNumber from '@/hooks/use-phone-number';
import { callToPhone } from '@/lib/utils';
import type { NavLink } from '@/types/navigation';

export const NavigationBar = () => {
    const phoneNumberOrigin = usePhoneNumber();
    const phoneNumber = usePhoneNumber(true);

    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
    const [isScrolled, setIsScrolled] = useState(false);

    const links: NavLink[] = [
        { href: '/#home', label: 'Strona główna' },
        { href: '/#services', label: 'Oferty' },
        { href: '/#about-us', label: 'O nas' },
        { href: '/#testimonials', label: 'Opinie' },
        { href: '/#partners', label: 'Partnerzy' },
        { href: '/#contact', label: 'Kontakt' },
    ];

    // Handle scroll effect
    useEffect(() => {
        const handleScroll = () => {
            setIsScrolled(window.scrollY > 20);
        };
        window.addEventListener('scroll', handleScroll);
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    // Close mobile menu on resize
    useEffect(() => {
        const handleResize = () => {
            if (window.innerWidth >= 1024) {
                setIsMobileMenuOpen(false);
            }
        };
        window.addEventListener('resize', handleResize);
        return () => window.removeEventListener('resize', handleResize);
    }, []);

    const toggleMobileMenu = () => setIsMobileMenuOpen(!isMobileMenuOpen);

    return (
        <nav
            id="navbar"
            className={`fixed top-0 left-0 z-50 w-full transition-all duration-300 ${
                isScrolled
                    ? 'bg-white/95 py-2 shadow-sm backdrop-blur-md'
                    : 'bg-white py-4'
            }`}
        >
            <div className="mx-auto flex w-full max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                {/* Logo */}
                <Link href="/" className="flex shrink-0 items-center">
                    <img
                        src={bawidelkaLogo}
                        alt="Bawidelka Logo"
                        width={120}
                        height={34}
                        className="h-auto w-28 transition-all duration-300 sm:w-32"
                    />
                </Link>

                {/* Desktop Navigation */}
                <div className="hidden lg:block">
                    <NavLinks links={links} />
                </div>

                {/* Right Side Actions */}
                <div className="flex items-center gap-4">
                    {/* Phone Number (Desktop) */}
                    <div className="hidden items-center gap-2 text-sm font-medium text-gray-700 transition-colors hover:text-mint-600 xl:flex">
                        <Phone className="h-4 w-4" />{' '}
                        <span itemProp="telephone">{phoneNumberOrigin}</span>
                    </div>

                    {/* Call Button */}
                    <Button
                        radius={'full'}
                        className="btn btn-primary text-center"
                        onClick={() => callToPhone(phoneNumber)}
                    >
                        Zadzwoń
                    </Button>

                    {/* Mobile Menu Toggle */}
                    <button
                        onClick={toggleMobileMenu}
                        className="rounded-lg p-2 text-gray-600 transition-colors hover:bg-gray-100 lg:hidden"
                        aria-label="Toggle mobile menu"
                    >
                        {isMobileMenuOpen ? (
                            <X className="h-6 w-6" />
                        ) : (
                            <Menu className="h-6 w-6" />
                        )}
                    </button>
                </div>
            </div>

            {/* Mobile Menu Overlay */}
            <div
                className={`fixed inset-0 z-40 duration-300 lg:hidden ${
                    isMobileMenuOpen
                        ? 'opacity-100'
                        : 'pointer-events-none opacity-0'
                }`}
                onClick={() => setIsMobileMenuOpen(false)}
            />

            {/* Mobile Menu Panel */}
            <div
                className={`fixed top-2.5 right-2.5 z-50 w-full max-w-xs transform border-t-gray-400 duration-300 ease-in-out lg:hidden ${
                    isMobileMenuOpen
                        ? 'translate-x-0'
                        : 'hidden translate-x-full'
                }`}
            >
                <div className="flex flex-col overflow-y-auto rounded-xl bg-white py-6">
                    <button
                        className="absolute top-4 right-4 text-gray-500 transition-colors duration-200 hover:text-gray-700"
                        onClick={() => setIsMobileMenuOpen(false)}
                    >
                        <X className="h-6 w-6" />
                    </button>
                    <div className="px-6">
                        <div className="flex flex-col space-y-4">
                            {links.map((link) => (
                                <Link
                                    key={link.href}
                                    href={link.href}
                                    className="text-lg font-medium text-gray-900 transition-colors hover:text-mint-600"
                                    onClick={() => setIsMobileMenuOpen(false)}
                                >
                                    {link.label}
                                </Link>
                            ))}
                        </div>

                        <div className="mt-8 border-t border-gray-100 pt-8">
                            <div className="flex flex-col gap-4">
                                <a
                                    href={`tel:${phoneNumber}`}
                                    className="flex items-center gap-3 text-lg font-medium text-gray-900"
                                >
                                    <div className="flex h-10 w-10 items-center justify-center rounded-full bg-mint-50 text-mint-600">
                                        <Phone className="h-5 w-5" />
                                    </div>
                                    {phoneNumberOrigin}
                                </a>
                                <Button
                                    size={'3'}
                                    radius={'full'}
                                    className="btn btn-lg btn-primary text-center"
                                    onClick={() => callToPhone(phoneNumber)}
                                >
                                    Zadzwoń teraz
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    );
};

export default NavigationBar;
