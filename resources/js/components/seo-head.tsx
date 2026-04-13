import { Head } from '@inertiajs/react';
import type { SeoMeta } from '@/types/models';

interface SeoHeadProps {
    title?: string;
    seo?: SeoMeta | null;
}

export default function SeoHead({ title, seo }: SeoHeadProps) {
    const defaultTitle = 'Bawidelka';
    const seoTitle = seo?.title || title || defaultTitle;
    const description = seo?.description || '';
    const keywords = seo?.keywords || '';
    const ogTitle = seo?.og_title || seoTitle;
    const ogDescription = seo?.og_description || description;
    const ogImage = seo?.og_image ? `/storage/${seo.og_image}` : '';

    return (
        <Head title={seoTitle}>
            {description && <meta name="description" content={description} />}
            {keywords && <meta name="keywords" content={keywords} />}

            <meta property="og:title" content={ogTitle} />
            {ogDescription && (
                <meta property="og:description" content={ogDescription} />
            )}
            {ogImage && <meta property="og:image" content={ogImage} />}
            <meta property="og:type" content="website" />

            <meta name="twitter:card" content="summary_large_image" />
            <meta name="twitter:title" content={ogTitle} />
            {ogDescription && (
                <meta name="twitter:description" content={ogDescription} />
            )}
            {ogImage && <meta name="twitter:image" content={ogImage} />}
        </Head>
    );
}
