"use client";

import { Inset } from '@radix-ui/themes';

interface OptimizedImageProps {
    src: string;
    alt: string;
    fill?: boolean;
    width?: number;
    height?: number;
    className?: string;
    priority?: boolean;
    quality?: number;
    sizes?: string;
}

/**
 * OptimizedImage component that wraps Next.js Image
 * Next.js automatically handles WebP conversion and optimization
 */
export function OptimizedImage({
    src,
    alt,
    fill,
    width,
    height,
    className,
    sizes,
}: OptimizedImageProps) {
    // Default sizes for responsive images when using fill
    const defaultSizes = fill
        ? "(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw"
        : undefined;

    return (
        <Inset clip="padding-box" side="top" pb="current">
        <img
            src={src}
            alt={alt}
            width={width}
            height={height}
            className={className}
            sizes={sizes || defaultSizes}
            style={{
                display: 'block',
                objectFit: 'cover',
                width: '100%',
                height: height ? `${height}px` : 'auto',
            }}
        />
        </Inset>
    );
}
