export interface Courses {
    data: Course[];
}

export interface Course {
    title: string;
    title_line2: string;
    description: string;
    slug: string;
    video_src: string;
    video_type: string;
    video_poster: string;
    background_src: string;
    meta_seo: string;
    meta_title: string;
    meta_description: string;
    meta_keywords: string;
    meta_image: string;
    sections: Section[];
    price: string;
    discount: string;
}

export interface Section {
    title: string;
    name: string;
    description: string;
    slug: string;
    course_id: number;
    course_price: number;
    video_src: string;
    video_type: string;
    video_poster: string;
    background_src: string;
    image_alt: string;
    color: string;
    meta_seo: string;
    meta_title: string;
    meta_description: string;
    meta_keywords: string;
    meta_image: string;
    lessons: Lesson[];
    lessons_count: number;
    duration: string;
    overview: string;
    s3_image: string;
    video_options: string;
    is_free: boolean;
}

export interface Lesson {
    name: string;
    duration: string;
    slug: string;
    activities: string;
    section_slug: string;
    meta_seo: string;
    meta_title: string;
    meta_description: string;
    meta_keywords: string;
    meta_image: string;
}
