'use client';
import StatsItemComponent from '@/components/main-sections/stats-item';
import type { StatsItem } from '@/types/models';

const stats: StatsItem[] = [
    { label: 'Wychowanków', value: '1000+' },
    { label: 'Nauczycieli', value: '50+' },
    { label: 'Lat Doświadczenia', value: '15' },
    { label: 'Zadowolonych Rodziców', value: '98%' },
];

export const StatsSection = () => {
    return (
        <section className="stats-section">
            <div className="stats-container">
                {stats.map((stat) => (
                    <StatsItemComponent
                        key={stat.label}
                        label={stat.label}
                        value={stat.value}
                    />
                ))}
            </div>
        </section>
    );
};

export default StatsSection;
