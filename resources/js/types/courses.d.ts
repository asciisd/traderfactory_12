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

export interface Sections {
    data: Section;
}

export interface SectionCan {
    view: boolean;
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
    can: SectionCan;
}

export interface Lesson {
    name: string;
    duration: string;
    slug: string;
    activities: Activity[];
    section_slug: string;
    meta_seo: string;
    meta_title: string;
    meta_description: string;
    meta_keywords: string;
    meta_image: string;
}

export interface Activity {
    model: string;
    item: Goal|Magazine|Visual;
    title: string;
    href: string;
}

export interface Goals {
    data: Goal
}

export interface Goal {
    id: number;
    title: string;
    section_title: string;
    points: string[];
    slug: string;
    duration: string;
    background_url: string;
    user_progress: number;
    icon: string;
    href: string;
    section_href: string;
    s3_image: string;
}

export interface Magazine {
    id: number;
    title: string;
    slug: string;
    duration: string;
    user_progress: number;
    icon: string;
    href: string;
    slides: string;
}

export interface Visual {
    id: string;
    title: string;
    description: string;
    slug: string;
    duration: string;
    duration_seconds: number;
    video_url: string;
    icon: string;
    href: string;
    user_progress: number;
}
