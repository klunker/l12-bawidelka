import { Link } from '@inertiajs/react';
import { Button } from '@radix-ui/themes';
import { ArrowLeft } from 'lucide-react';
import { OptimizedImage } from '@/components/ui/optimized-image';
import ServiceOptions from '@/components/ui/service-options';
import showAttachment from '@/components/ui/show-attachment';

import usePhoneNumber from '@/hooks/use-phone-number';
import { callToPhone } from '@/lib/utils';
import type { Attachment, Service } from '@/types/models';

interface TemplateProps {
    service: Service;
}

export default function StandardTemplate({ service }: TemplateProps) {
    const phoneNumber = usePhoneNumber(true);

    const serviceOptions = Array.isArray(service.options)
        ? (service.options as string[])
        : [];

    return (
        <div className="py-16">
            {/* Back link */}
            <div className="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <Link
                    href="/#services"
                    className="group inline-flex items-center text-gray-600 transition-colors hover:text-mint-600"
                >
                    <ArrowLeft className="mr-2 h-5 w-5 transition-transform group-hover:-translate-x-1" />
                    Powrót do ofert
                </Link>
            </div>

            {/* Hero image with title overlay */}
            <div className="rounded-0 relative mx-auto h-80 max-w-6xl overflow-hidden sm:h-96 md:h-[480px] md:rounded-4xl">
                <OptimizedImage
                    src={service.header_image_url}
                    alt={service.title}
                    height={500}
                    width={1200}
                    className="object-cover object-center"
                    priority
                />
                {/* Gradient overlay */}
                <div className="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent" />

                {/* Title on image */}
                <div className="absolute right-0 bottom-0 left-0 p-6 sm:p-10">
                    <div className="mx-auto max-w-5xl">
                        <h1 className="text-4xl! font-bold text-white! md:text-6xl!">
                            {service.title}
                        </h1>
                        {service.sub_title && (
                            <p className="mt-2 text-3xl text-white/80">
                                {service.sub_title}
                            </p>
                        )}
                    </div>
                </div>
            </div>

            {/* Content below hero */}
            <div className="mx-auto max-w-6xl px-4 pt-10 sm:px-6 lg:px-8">
                <div id="content">
                    <div
                        className="prose prose-lg max-w-none text-gray-600"
                        dangerouslySetInnerHTML={{
                            __html: service.description,
                        }}
                    />

                    <ServiceOptions serviceOptions={serviceOptions} />

                    {/* Attachments Section */}
                    {service.attachments_urls &&
                        service.attachments_urls.length > 0 && (
                            <div className="mt-8">
                                <h3 className="mb-4 text-xl font-semibold text-primary">
                                    Pliki do pobrania
                                </h3>
                                <div className="flex flex-col gap-2">
                                    {service.attachments_urls.map(
                                        (
                                            attachment: Attachment,
                                            index: number,
                                        ) => (
                                            <div key={index}>
                                                {showAttachment(
                                                    index,
                                                    attachment,
                                                )}
                                            </div>
                                        ),
                                    )}
                                </div>
                            </div>
                        )}

                    <div className="mt-10">
                        <Button
                            radius={'full'}
                            className="btn btn-primary text-center"
                            onClick={() => callToPhone(phoneNumber)}
                        >
                            Zadzwoń
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    );
}
