import { Quote, Star } from 'lucide-react';
import { useState } from 'react';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import type { GoogleReview } from '@/types/models';

interface GoogleReviewsSectionProps {
    reviews: Array<GoogleReview>;
}

const TestimonialsSection: React.FC<GoogleReviewsSectionProps> = ({
    reviews,
}) => {
    const [visibleCount, setVisibleCount] = useState(3);

    const generateKey = (model: unknown): string => {
        const str = JSON.stringify(model);
        let hash = 0;
        for (let i = 0; i < str.length; i++) {
            const char = str.charCodeAt(i);
            hash = (hash << 5) - hash + char;
            hash = hash & hash; // Convert to 32bit integer
        }
        return Math.abs(hash).toString(36);
    };
    const renderStars = (rating: number) => {
        return Array(5)
            .fill(0)
            .map((_, i: number) => (
                <Star
                    key={generateKey({ _, i })}
                    size={16}
                    className={`${i < rating ? 'fill-yellow-400 text-yellow-400' : 'text-gray-300'}`}
                    aria-hidden="true"
                />
            ));
    };

    const handleLoadMore = () => {
        setVisibleCount((prev) => prev + 6);
    };

    const visibleReviews = reviews ? reviews.slice(0, visibleCount) : [];
    const hasMore = reviews && visibleCount < reviews.length;

    return (
        <section className="bg-white py-20" id="testimonials">
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <header className="mb-16 text-center">
                    <p className="tracking-wide text-mint-800">Opinie</p>
                    <h2 className="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Co mówią o nas rodzice?
                    </h2>
                    <p className="mx-auto mt-4 max-w-2xl text-xl text-gray-500">
                        Zaufanie rodziców jest dla nas najważniejsze. Zobacz
                        opinie z Google Maps.
                    </p>
                </header>

                {visibleReviews.length > 0 ? (
                    <ul className="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                        {visibleReviews.map((review) => (
                            <article
                                key={review.id || review.time}
                                className="relative flex h-full flex-col rounded-2xl bg-gray-50 p-8 shadow-lg transition-shadow duration-300 hover:shadow-xl"
                                itemScope
                                itemType="https://schema.org/Review"
                                itemProp="review"
                            >
                                <Quote
                                    className="absolute top-4 right-4 h-12 w-12 rotate-180 transform text-mint-200"
                                    aria-hidden="true"
                                />

                                <div className="mb-6 flex items-center">
                                    <div className="shrink-0">
                                        <Avatar className="h-12 w-12 bg-mint-100 text-mint-700">
                                            <AvatarImage
                                                src={review.profile_photo_url}
                                                referrerPolicy="no-referrer"
                                            />
                                            <AvatarFallback>
                                                {review.author_name.charAt(0)}
                                            </AvatarFallback>
                                        </Avatar>
                                    </div>
                                    <div className="ml-4">
                                        <h3
                                            className="text-lg font-medium text-gray-900"
                                            itemProp="author"
                                        >
                                            {review.author_name}
                                        </h3>
                                        <div
                                            className="mt-1 flex items-center"
                                            itemProp="reviewRating"
                                            itemScope
                                            itemType="https://schema.org/Rating"
                                        >
                                            <meta
                                                itemProp="ratingValue"
                                                content={review.rating.toString()}
                                            />
                                            <meta
                                                itemProp="bestRating"
                                                content="5"
                                            />
                                            {renderStars(review.rating)}
                                        </div>
                                    </div>
                                </div>

                                <blockquote
                                    className="relative z-10 mb-6 grow text-gray-600 italic"
                                    itemProp="reviewBody"
                                >
                                    <p>
                                        &ldquo;
                                        {review.text && review.text.length > 150
                                            ? `${review.text.substring(0, 150)}...`
                                            : review.text ||
                                              'No text available'}
                                        &rdquo;
                                    </p>
                                </blockquote>

                                <footer className="mt-auto flex items-center justify-between">
                                    <time
                                        dateTime={new Date(
                                            review.time * 1000,
                                        ).toISOString()}
                                        className="text-sm text-gray-400"
                                        itemProp="datePublished"
                                    >
                                        {review.relative_time_description}
                                    </time>
                                    <div className="flex items-center text-sm text-gray-500">
                                        <svg
                                            className="mr-2 h-4 w-4"
                                            role="img"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <title>Google</title>
                                            <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z" />
                                        </svg>
                                        <span>Google Review</span>
                                    </div>
                                </footer>
                            </article>
                        ))}
                    </ul>
                ) : (
                    <div className="py-12 text-center text-gray-500">
                        Brak opinii do wyświetlenia. Kliknij przycisk powyżej,
                        aby pobrać opinie z Google.
                    </div>
                )}

                <div className="mt-12 flex flex-col items-center gap-4">
                    {hasMore ? (
                        <button
                            onClick={handleLoadMore}
                            className="btn btn-primary"
                            aria-label="Załaduj więcej opinii"
                        >
                            Załaduj więcej opinii
                        </button>
                    ) : (
                        <a
                            href="https://maps.app.goo.gl/7VF1FNNa6Qn5yo7U8"
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-mint-600 hover:underline"
                            aria-label="Zobacz wszystkie opinie na Google Maps (otwiera się w nowej karcie)"
                        >
                            Zobacz wszystkie opinie na Google Maps
                        </a>
                    )}
                </div>
            </div>
        </section>
    );
};

export default TestimonialsSection;
