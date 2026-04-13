export type City = {
    id: number;
    name: string;
    title: string;
    address: string;
    postal_code: string;
    phone: string;
    active: boolean;
    created_at: string;
    updated_at: string;
    facebook: string;
    instagram: string;
    nip: string;
    regon: string;
};

export type AboutContent = {
    id: number;
    content: string;
    isActive: boolean;
    created_at: string;
    updated_at: string;
};

export type Reason = {
    id: number;
    title: string;
    description: string;
    image: string;
    image_url: string;
    attachments: string;
    isActive: boolean;
    deleted_at: string;
    created_at: string;
    updated_at: string;
};

export type Service = {
    id: string;
    slug: string;
    image: string;
    image_url: string;
    header_image: string;
    header_image_url: string;
    title: string;
    sub_title: string | null;
    description: string;
    description_additional: string;
    createdAt: Date; // Make required since DB will always provide it
    updatedAt: Date; // Make required since DB provide it
    deletedAt: Date | null; // Always use Date | null for consistency
    isActive: boolean;
    template: string;
    options: Array<string>;
    attachments: Array<Attachment>;
    attachments_urls: Array<Attachment>;
    cities?: { id: number; name: string }[];
    seoMeta?: SeoMeta;
};

export type Attachment = {
    file: string;
    url: string;
    name: string;
};

export type FAQItem = {
    id: string;
    question: string;
    answer: string;
};

export type Partner = {
    id: string;
    name: string;
    slug: string;
    logo: string;
    logo_url: string;
    photo: string;
    photo_url: string;
    url: string;
    description: string | null;
    createdAt: Date;
    updatedAt: Date;
    isActive: boolean;
    order: number;
};

export type GoogleReview = {
    id: string;
    author_name: string;
    rating: number;
    relative_time_description: string;
    time: number;
    author_url?: string;
    language?: string;
    original_language?: string;
    profile_photo_url?: string;
    text?: string;
    translated?: boolean;
};

export type Activity = {
    id: string;
    name: string;
    slug: string;
    description: string;
    image: string;
    image_url: string;
    price: number;
    weekendPrice: number;
    duration: string;
    order: number;
    ageFrom: number | null;
    ageTo: number | null;
    maxChildren: number | null;
    numChildren: number | null;
    extra_price: number | null;
    createdAt: Date;
    updatedAt: Date;
    deletedAt: Date | null;
    isActive: boolean;
    features?: string[] | string;
    badge?: string | null;
    color?: string | null;
    cities?: { id: number; name: string }[];
};

export type SeoMeta = {
    id: number;
    title: string | null;
    description: string | null;
    keywords: string | null;
    og_title: string | null;
    og_description: string | null;
    og_image: string | null;
};

export type Page = {
    id: number;
    slug: string;
    title: string;
    content: string;
    is_active: boolean;
    seoMeta?: SeoMeta;
};

export type StatsItem = {
    label: string;
    value: string;
};
