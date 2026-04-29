import AboutUsSection from '@/components/main-sections/about-us-section';
import CtaSection from '@/components/main-sections/cta-section';
import FAQ from '@/components/main-sections/faq-section';
import FooterSection from '@/components/main-sections/footer-section';
import HeroSection from '@/components/main-sections/hero-section';
import NavigationBar from '@/components/main-sections/navigation-bar';
import PartnersSection from '@/components/main-sections/partners-section';
import ReasonTextSection from '@/components/main-sections/reason-text-section';
import ServiceSection from '@/components/main-sections/service-section';
import TestimonialsSection from '@/components/main-sections/testimonials-section';
import SeoHead from '@/components/seo-head';
import usePhoneNumber from '@/hooks/use-phone-number';
import { usePhoneCall } from '@/contexts/phone-call-context';
import { callToPhone } from '@/lib/utils';
import { useEffect } from 'react';
import type {
    AboutContent,
    City,
    FAQItem,
    GoogleReview,
    Partner,
    Reason,
    SeoMeta,
    Service,
} from '@/types/models';

export default function Welcome({
    Cities,
    Services,
    Reasons,
    Faqs,
    Partners,
    GoogleReviews,
    AboutContent,
    seo,
}: {
    Cities: Array<City>;
    Services: Array<Service>;
    Reasons: Array<Reason>;
    Faqs: Array<FAQItem>;
    Partners: Array<Partner>;
    GoogleReviews: Array<GoogleReview>;
    AboutContent?: AboutContent | null;
    seo: SeoMeta | null;
}) {
    const phoneNumber = usePhoneNumber(true);
    const { setCities } = usePhoneCall();

    // Set cities in context when component mounts
    useEffect(() => {
        if (Cities && Cities.length > 0) {
            setCities(Cities);
        }
    }, [Cities, setCities]);

    return (
        <>
            <SeoHead title="Welcome" seo={seo} />
            <NavigationBar />
            <HeroSection />
            {/*<ReasonSection reasons={Reasons} />*/}
            <ReasonTextSection reasons={Reasons} />
            <ServiceSection services={Services} cities={Cities} />
            <AboutUsSection AboutContent={AboutContent} />
            <TestimonialsSection reviews={GoogleReviews} />
            <FAQ faqs={Faqs} />
            <PartnersSection partners={Partners} />
            <CtaSection
                title="Gotowy na rozpoczęcie przygody?"
                description="Dołącz do setek rodzin, które już odkryły idealne miejsce dla swoich dzieci, gdzie mogą się uczyć, rozwijać i osiągać sukcesy."
                buttonLabel="Zacznij już dziś"
                func={() => {
                    callToPhone(phoneNumber);
                }}
            />
            <FooterSection cities={Cities} />
        </>
    );
}
