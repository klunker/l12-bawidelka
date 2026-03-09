import FooterSection from '@/components/main-sections/footer-section';
import NavigationBar from '@/components/main-sections/navigation-bar';
import SeoHead from '@/components/seo-head';
import type { City, Page, SeoMeta } from '@/types/models';

interface StaticPageProps {
    page: Page;
    seo: SeoMeta | null;
    Cities: City[];
}

export default function StaticPage({ page, seo, Cities }: StaticPageProps) {
    return (
        <>
            <SeoHead title={page.title} seo={seo} />
            <NavigationBar />

            <main className="bg-white py-20">
                <div className="container mx-auto mt-3 max-w-7xl rounded-xl bg-gray-50 px-4 py-6 sm:px-6 lg:px-8 lg:py-10">
                    <h1 className="mb-8 text-4xl font-bold text-gray-900">
                        {page.title}
                    </h1>
                    <div
                        className="prose prose-lg max-w-none text-gray-700"
                        dangerouslySetInnerHTML={{ __html: page.content }}
                    />
                </div>
            </main>

            <FooterSection cities={Cities} />
        </>
    );
}
