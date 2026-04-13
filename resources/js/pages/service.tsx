import { lazy, Suspense, useEffect, useMemo } from 'react';
import FooterSection from '@/components/main-sections/footer-section';
import NavigationBar from '@/components/main-sections/navigation-bar';
import SeoHead from '@/components/seo-head';
import type { Activity, City, SeoMeta, Service } from '@/types/models';

// Define the template map outside the component to avoid re-creation on every render
const templates = {
    standard: lazy(() => import('@/pages/service/Standard')),
    special: lazy(() => import('@/pages/service/Special')),
    trip: lazy(() => import('@/pages/service/Trip')),
    urodzinki: lazy(() => import('@/pages/service/Urodzinki')),
};

const FallbackTemplate = lazy(() => import('@/pages/service/Standard'));

export default function ServicePage({
    Service,
    Cities,
    Activities,
    seo,
}: {
    Service: Service;
    Cities: Array<City>;
    Activities: Array<Activity>;
    seo: SeoMeta | null;
}) {
    // Select the correct component based on the service template
    const TemplateComponent = useMemo(() => {
        const templateName = Service.template?.toLowerCase();
        return (
            templates[templateName as keyof typeof templates] ||
            FallbackTemplate
        );
    }, [Service.template]);

    useEffect(() => {
        // Восстанавливаем позицию скролла при монтировании
        const scrollY = localStorage.getItem('serviceScrollPosition');
        if (scrollY) {
            requestAnimationFrame(() => {
                window.scrollTo(0, parseInt(scrollY, 10));

                setTimeout(() => {
                    const currentScroll = window.scrollY;
                    const targetScroll = parseInt(scrollY, 10);

                    if (currentScroll === targetScroll) {
                        localStorage.removeItem('serviceScrollPosition');
                    } else {
                        setTimeout(() => {
                            window.scrollTo(0, targetScroll);
                            console.log('Second attempt to apply scroll');
                        }, 200);
                    }
                }, 200);
            });
        }

        const handleScroll = () => {
            localStorage.setItem(
                'serviceScrollPosition',
                window.scrollY.toString(),
            );
        };

        const handleBeforeUnload = () => {
            localStorage.setItem(
                'serviceScrollPosition',
                window.scrollY.toString(),
            );
        };

        window.addEventListener('scroll', handleScroll);
        window.addEventListener('beforeunload', handleBeforeUnload);

        return () => {
            window.removeEventListener('scroll', handleScroll);
            window.removeEventListener('beforeunload', handleBeforeUnload);
        };
    }, []);

    return (
        <>
            <SeoHead title={Service.title} seo={seo} />
            <NavigationBar />
            <main className="min-h-screen bg-white">
                <Suspense
                    fallback={
                        <div className="flex h-screen items-center justify-center">
                            Loading...
                        </div>
                    }
                >
                    <TemplateComponent
                        service={Service}
                        activities={Activities}
                    />
                </Suspense>
            </main>
            <FooterSection cities={Cities} />
        </>
    );
}
