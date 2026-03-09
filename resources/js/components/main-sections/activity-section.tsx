'use client';
import { Check } from 'lucide-react';
import React, { useEffect, useState } from 'react';
import {
    Empty,
    EmptyDescription,
    EmptyHeader,
    EmptyTitle,
} from '@/components/ui/empty';
import { OptimizedImage } from '@/components/ui/optimized-image';
import type { Activity } from '@/types/models';

const ActivityCard: React.FC<{ activity: Activity }> = ({ activity }) => {
    let colorClass: string;
    switch (activity.color) {
        case 'mint':
            colorClass = 'mint';
            break;
        case 'brown':
            colorClass = 'brown';
            break;
        case 'pink-pounder':
            colorClass = 'pinkpounder';
            break;
        case 'peach':
            colorClass = 'peach';
            break;
        case 'pistachio':
            colorClass = 'pistachio';
            break;
        case 'lavender':
            colorClass = 'lavender';
            break;
        default:
            colorClass = 'default';
            break;
    }

    const themeColors: Record<
        string,
        {
            border: string;
            header: string;
            badge: string;
            button: string;
            text: string;
            bgLight: string;
        }
    > = {
        mint: {
            border: 'border-brand-color-mint',
            header: 'bg-mint-700',
            badge: 'bg-mint-800',
            button: 'bg-mint-700 hover:bg-mint-700',
            text: 'text-grey-800',
            bgLight: 'brand-bgColor-mint',
        },
        brown: {
            border: 'border-brand-color-brown',
            header: 'bg-brown-600',
            badge: 'bg-brown-700',
            button: 'bg-mint-700 hover:bg-mint-700',
            text: 'text-grey-800',
            bgLight: 'brand-bgColor-brown',
        },
        pinkpounder: {
            border: 'border-brand-color-pink-pounder',
            header: 'bg-pink-700',
            badge: 'bg-pink-800',
            button: 'bg-mint-700 hover:bg-mint-700',
            text: 'text-grey-800',
            bgLight: 'brand-bgColor-pink-pounder',
        },
        peach: {
            border: 'border-brand-color-peach',
            header: 'bg-cream-700',
            badge: 'bg-cream-800',
            button: 'bg-mint-700 hover:bg-mint-700',
            text: 'text-grey-800',
            bgLight: 'brand-bgColor-peach',
        },
        pistachio: {
            border: 'border-brand-color-pistachio',
            header: 'bg-cream-700',
            badge: 'bg-cream-800',
            button: 'bg-mint-700 hover:bg-mint-700',
            text: 'text-grey-800',
            bgLight: 'brand-bgColor-pistachio',
        },
        lavender: {
            border: 'border-brand-color-lavender',
            header: 'bg-lavender-700',
            badge: 'bg-lavender-800',
            button: 'bg-mint-700 hover:bg-mint-700',
            text: 'text-grey-800',
            bgLight: 'brand-bgColor-lavender',
        },
    };

    const theme = themeColors[colorClass] || themeColors.mint;

    console.log('Activity', activity);
    return (
        <div
            className={`flex h-full flex-col overflow-hidden rounded-4xl border bg-white ${theme.border} group shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]`}
        >
            {/* Image Wrapper */}
            <div className="relative aspect-16/10 overflow-hidden">
                <OptimizedImage
                    src={activity.image_url}
                    alt={activity.name}
                    width={355}
                    height={222}
                    className="object-cover transition-transform duration-500 group-hover:scale-110"
                    sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw"
                />
                {activity.badge && (
                    <div
                        className={`absolute top-4 right-4 ${theme.badge} rounded-full px-3 py-1 text-[10px] font-bold tracking-wider text-white uppercase shadow-sm`}
                    >
                        {activity.badge}
                    </div>
                )}
            </div>

            {/* Content */}
            <div className="flex grow flex-col p-6">
                <div className="mb-4">
                    <p
                        className={`text-[10px] font-bold tracking-[0.2em] uppercase ${theme.text} mb-1 opacity-70`}
                    >
                        Pakiet urodzinowy
                    </p>
                    <h3 className="mb-0! text-2xl leading-tight font-black text-gray-900">
                        {activity.name}
                    </h3>
                    <p className="text-sm">
                        Max illość osób: {activity.maxChildren} osób
                    </p>
                </div>

                {/* Pricing Table */}
                <div
                    className={`rounded-2xl ${theme.bgLight} mb-6 space-y-3 p-4`}
                >
                    <div className="mb-1 flex items-center justify-between">
                        <p className="text-xs font-bold tracking-wide text-gray-900 uppercase">
                            pon–pt
                        </p>
                        <p className="text-lg font-black text-gray-900">
                            {activity.price} zł
                        </p>
                    </div>
                    <div className="mb-1 flex items-center justify-between">
                        <p className="text-xs font-bold tracking-wide text-gray-900 uppercase">
                            weekend i święta
                        </p>
                        <p className="text-lg font-black text-gray-900">
                            {activity.weekendPrice} zł
                        </p>
                    </div>
                    {activity.extra_price && (
                        <div className="flex items-center justify-between">
                            <div className="space-y-0.5">
                                <p className="text-xs font-bold tracking-wide text-gray-900 uppercase">
                                    {activity.numChildren} dzieci w cenie
                                </p>
                                <p className="text-[10px] text-gray-800 italic">
                                    + każde kolejne dziedcko
                                </p>
                            </div>
                            <p className="text-lg font-black text-gray-900">
                                +{activity.extra_price} zł
                            </p>
                        </div>
                    )}
                </div>

                <div
                    className="mb-6 line-clamp-2 text-sm leading-relaxed text-gray-600"
                    dangerouslySetInnerHTML={{ __html: activity.description }}
                />

                {/* Features list */}
                <div className="mb-8 grow">
                    <p className="mb-3 text-sm font-black text-gray-900">
                        Zapewniamy:
                    </p>
                    <ul className="space-y-2.5 p-0!">
                        {(() => {
                            let featuresArray: string[] = [];
                            try {
                                if (Array.isArray(activity.features)) {
                                    featuresArray = activity.features;
                                } else if (
                                    typeof activity.features === 'string'
                                ) {
                                    featuresArray = JSON.parse(
                                        activity.features,
                                    );
                                }
                            } catch (e) {
                                console.error('Error parsing features:', e);
                            }

                            if (!Array.isArray(featuresArray)) return null;

                            return featuresArray.map((feature, idx) => (
                                <li
                                    key={idx}
                                    className="flex items-start gap-2.5 text-sm leading-tight text-gray-600"
                                >
                                    <div
                                        className={`mt-0.5 rounded-full p-0.5 ${theme.bgLight}`}
                                    >
                                        <Check
                                            className={`h-3 w-3 ${theme.text}`}
                                        />
                                    </div>
                                    <span>{feature}</span>
                                </li>
                            ));
                        })()}
                    </ul>
                </div>
            </div>
        </div>
    );
};

interface ActivitySectionProps {
    activities: Array<Activity>;
}

const ActivitySection: React.FC<ActivitySectionProps> = ({
    activities = [],
}) => {
    const [selectedCityId, setSelectedCityId] = useState<string | null>(null);

    useEffect(() => {
        const getCookie = (name: string) => {
            const match = document.cookie.match(
                new RegExp('(^| )' + name + '=([^;]+)'),
            );
            if (match) return match[2];
            return null;
        };

        const updateCityFromCookie = () => {
            const savedCityId = getCookie('selectedCityId');
            setSelectedCityId(savedCityId || 'all');
        };

        updateCityFromCookie();

        // Check for cookie changes periodically as there's no native cookie listener
        const interval = setInterval(updateCityFromCookie, 1000);
        return () => clearInterval(interval);
    }, []);

    const filteredActivities = activities.filter((activity) => {
        if (!selectedCityId || selectedCityId === 'all') return true;
        // Ensure cities array exists and has items
        if (!activity.cities || !Array.isArray(activity.cities)) {
            console.warn(
                'Activity has no cities array:',
                activity.id,
                activity.name,
            );
            return false;
        }
        return activity.cities.some(
            (city: { id: number; name: string }) =>
                city.id.toString() === selectedCityId,
        );
    });

    if (filteredActivities.length === 0) {
        return (
            <div>
                <Empty>
                    <EmptyHeader>
                        <EmptyTitle>Brak atrakcji</EmptyTitle>
                        <EmptyDescription className={'text-black'}>
                            Nie utworzono jeszcze żadnych atrakcji. Zacznij od
                            utworzenia swojej pierwszej atrakcji.
                        </EmptyDescription>
                    </EmptyHeader>
                </Empty>
            </div>
        );
    }

    return (
        <section className="rounded-xl bg-[#FEFEFE] py-10" id="activities">
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div className="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-3">
                    {filteredActivities.map((activity) => (
                        <ActivityCard key={activity.id} activity={activity} />
                    ))}
                </div>
            </div>
        </section>
    );
};

export default ActivitySection;
