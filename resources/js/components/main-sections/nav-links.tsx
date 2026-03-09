import { Link } from '@inertiajs/react';
import clsx from 'clsx';
import type { NavLink, NavLinksProps } from '@/types/navigation';

export const NavLinks = ({ links, className }: NavLinksProps) => (
    <ul className={clsx('hidden items-center gap-8 lg:flex', className)}>
        {links.map((link: NavLink) => (
            <li key={link.href}>
                <Link
                    href={link.href}
                    className="text-sm font-medium text-gray-600 transition-colors duration-200 hover:text-brown-500"
                >
                    {link.label}
                </Link>
            </li>
        ))}
    </ul>
);
